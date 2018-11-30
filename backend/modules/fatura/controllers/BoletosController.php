<?php

namespace backend\modules\fatura\controllers;

use backend\commands\Basicos;
use backend\modules\fatura\models\BoletoRegistro;
use backend\modules\fatura\models\Fatura;
use Yii;
use backend\modules\fatura\models\FaturaBoleto;
use backend\modules\fatura\models\FaturaBoletoSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BoletosController implements the CRUD actions for FaturaBoleto model.
 */
class BoletosController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'matchCallback' => function ($rule, $action) {
                            throw new HttpException(403, 'Usuário bloqueado! Entre em contato para solucionar este erro.');
                        },
                        'roles' => ['bloqueado'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['acessoBasico'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all FaturaBoleto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FaturaBoletoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FaturaBoleto model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FaturaBoleto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($fatura)
    {

        $modelFatura = $this->findFatura($fatura);

        if (!is_null($modelFatura->faturaBoleto)) {
            return $this->redirect([
                'update',
                'fatura' => $modelFatura->id,
                'id' => $modelFatura->faturaBoleto->id
            ]);
        }

        $model = new FaturaBoleto();
        $basicos = new Basicos();

        if ($model->load(Yii::$app->request->post())) {

            // Id da Fatura
            $model->fatura_id = $fatura;

            // Status do Boleto
            $model->status = 'GERADO';

            // Datas
            $model->dtEmissaoTitulo = $basicos->formataData('db', $model->dtEmissaoTitulo);
            $model->dtVencimentoTitulo = $basicos->formataData('db', $model->dtVencimentoTitulo);

            // Salva o Boleto
            if ($model->save()) {
                return $this->redirect(['registra', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelFatura' => $modelFatura,
            ]);
        }
    }

    /**
     * Updates an existing FaturaBoleto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($fatura, $id)
    {
        $model = $this->findModel($id);

        if ($model->status == 'REGISTRADO') {
            return $this->redirect(['imprime', 'id' => $model->id]);
        }

        $modelFatura = $this->findFatura($fatura);
        $basicos = new Basicos();

        if ($model->load(Yii::$app->request->post())) {

            // Status do Boleto
            $model->status = 'GERADO';

            // Datas
            $model->dtEmissaoTitulo = $basicos->formataData('db', $model->dtEmissaoTitulo);
            $model->dtVencimentoTitulo = $basicos->formataData('db', $model->dtVencimentoTitulo);

            $model->save();

            return $this->redirect(['registra', 'id' => $model->id]);
        } else {

            // Datas
            $model->dtEmissaoTitulo = $basicos->formataData('form', $model->dtEmissaoTitulo);
            $model->dtVencimentoTitulo = $basicos->formataData('form', $model->dtVencimentoTitulo);

            return $this->render('update', [
                'model' => $model,
                'modelFatura' => $modelFatura,
            ]);
        }
    }

    /**
     * Deletes an existing FaturaBoleto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionRegistra($id)
    {
        $configJson = Yii::getAlias('@sped/config/') . Yii::$app->user->identity['cnpj'] . '.json';
        $boletoRegistro = new BoletoRegistro($configJson);
        $modelBoleto = $this->findModel($id);
        if ($modelBoleto->status != 'REGISTRADO') {
            $arquivo = $boletoRegistro->criaRemessa($modelBoleto);
            $assinatura = $boletoRegistro->assinaRemessa($arquivo);
            $envio = $boletoRegistro->solicitaRegistro($assinatura, $modelBoleto, 'PRODUCAO');

            return $this->actionImprime($id);
        } else {
            return $this->actionImprime($id);
        }
    }

    public function actionImprime($id)
    {
        $configJson = Yii::getAlias('@sped/config/') . Yii::$app->user->identity['cnpj'] . '.json';
        $boletoRegistro = new BoletoRegistro($configJson);
        $modelBoleto = $this->findModel($id);

        $infs = $boletoRegistro->getRetorno($modelBoleto->file);

        return $this->renderPartial('boleto', [
            'modelBoleto' => $modelBoleto,
            'infs' => $infs
        ]);
    }

    public function actionPrint($id, $retorno = true)
    {

        $configJson = Yii::getAlias('@sped/config/') . Yii::$app->user->identity['cnpj'] . '.json';
        $boletoRegistro = new BoletoRegistro($configJson);
        $modelBoleto = $this->findModel($id);

        $infs = $boletoRegistro->getRetorno($modelBoleto->file);

        $this->layout = 'fatura-print';

        $conteudoPDF = $this->renderPartial('boleto', [
            'modelBoleto' => $modelBoleto,
            'infs' => $infs
        ]);

        // Local para se salvar as Minutas em PDF
        $path = 'pdfs/faturas/'.\Yii::$app->user->identity['cnpj'].'/Gerador-B'.$modelBoleto->id.'.pdf';

        Yii::$app->html2pdf
            ->convert($conteudoPDF)
            ->saveAs($path);

        if (!$retorno) {
            return $path;
        }

        if (is_file($path)) {

            // Set up PDF headers
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="'.'/LNDSistemas-F'.$model->numero.'.pdf'.'"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: '.filesize($path));
            header('Accept-Ranges: bytes');

            // Retorna arquivo PDF
            return readfile($path);
        } else {
            // Retorna arquivo PHP
            return $conteudoPDF;
        }

        return $this->render('print',
            [
                'model' => $model,
            ]);
    }

    /**
     * Finds the FaturaBoleto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FaturaBoleto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FaturaBoleto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Fatura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Fatura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findFatura($fatura)
    {
        if (($modelFatura = Fatura::findOne($fatura)) !== null) {
            return $modelFatura;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
