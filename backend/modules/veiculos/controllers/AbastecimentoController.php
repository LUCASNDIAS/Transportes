<?php

namespace backend\modules\veiculos\controllers;

use backend\modules\veiculos\models\Veiculos;
use Yii;
use backend\modules\veiculos\models\VeiculosAbastecimento;
use backend\modules\veiculos\models\VeiculosAbastecimentoSearch;
use backend\modules\financeiro\models\Financeiro;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\commands\Basicos;

/**
 * AbastecimentoController implements the CRUD actions for VeiculosAbastecimento model.
 */
class AbastecimentoController extends Controller
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
     * Lists all VeiculosAbastecimento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VeiculosAbastecimentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VeiculosAbastecimento model.
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
     * Creates a new VeiculosAbastecimento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VeiculosAbastecimento();

        $modelVeiculos = new Veiculos();
        $data = $modelVeiculos->autoComplete();

        if ($model->load(Yii::$app->request->post())) {

            $despesa = new Financeiro();
            $despesa->cridt = $model->cridt;
            $despesa->criusu = $model->criusu;
            $despesa->dono = $model->dono;
            $despesa->nome = $model->posto;
            $despesa->descricao = 'ABASTECIMENTO - ' . $model->veiculo0->placa . ' - ' . $model->combustivel;
            $despesa->emissao = $model->cridt;
            $despesa->vencimento = $model->cridt;
            $despesa->valor = $model->valor_total;
            $despesa->dtpgto = $model->cridt;
            $despesa->sacado = null;
            $despesa->fatura = null;
            $despesa->tipo = 'D';
            $despesa->status = 'PAGO';

            $model->financeiro = $despesa->save() ? $despesa->id : null;
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'data' => $data
            ]);
        }
    }

    /**
     * Updates an existing VeiculosAbastecimento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $basicos = new Basicos();
        $modelVeiculos = new Veiculos();
        $data = $modelVeiculos->autoComplete();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $despesa = $this->findFinanceiro($model->financeiro);
            $despesa->cridt = $model->cridt;
            $despesa->criusu = $model->criusu;
            $despesa->dono = $model->dono;
            $despesa->nome = $model->posto;
            $despesa->descricao = 'ABASTECIMENTO - ' . $model->veiculo0->placa . ' - ' . $model->combustivel;
            $despesa->emissao = $model->cridt;
            $despesa->vencimento = $model->cridt;
            $despesa->valor = $model->valor_total;
            $despesa->dtpgto = $model->cridt;
            $despesa->sacado = null;
            $despesa->fatura = null;
            $despesa->tipo = 'D';
            $despesa->status = 'PAGO';

            $despesa->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            $model->data = $basicos->formataData('form', $model->data);

            return $this->render('update', [
                'model' => $model,
                'data' => $data
            ]);
        }
    }

    /**
     * Deletes an existing VeiculosAbastecimento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $despesa = $this->findFinanceiro($model->financeiro);
        $model->delete();
        $despesa->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VeiculosAbastecimento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VeiculosAbastecimento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VeiculosAbastecimento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Financeiro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VeiculosAbastecimento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findFinanceiro($id)
    {
        if (($financeiro = Financeiro::findOne($id)) !== null) {
            return $financeiro;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
