<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Minutas;
use backend\models\MinutasSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\clientes\models\Clientes;
use backend\models\Tabelas;
use backend\models\EnviaEmail;

/**
 * MinutasController implements the CRUD actions for Minutas model.
 */
class MinutasController extends Controller {

    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all Minutas models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MinutasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Minutas model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Minutas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Minutas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['index']);
//            return $this->redirect(['view', 'id' => $model->id]);

            /* Var_dump do calculo com os dados do formulário 
              $formulario = Yii::$app->request->post();
              sif ( !empty($formulario)) {

              $modelo = $this->findModel(4);

              $calculos = new Calculos();
              $calculaFrete = $calculos->calculaFrete('db',$formulario);

              echo '<pre>';
              var_dump($calculaFrete);
             */
        } else {
            //$formulario = (\Yii::$app->request->post() !== null) ? $model->getErrors() : 'fudeu';

            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Minutas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            // Tabelas do pagador
            $cnpj = $model->pagadorcnpj;

            $cliente = new Clientes;
            $tabcli = $cliente->Tabelas($cnpj);

            $tabelas = new Tabelas();
            $tab = $tabelas->listarTabelas($tabcli, false);

            //var_dump($tab);
            // var_dump($model->getErrors());
            return $this->render('update', [
                        'model' => $model,
                        'tabela' => $tab
            ]);
        }
    }

    /**
     * Deletes an existing Minutas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Cria o arquivo PDF de uma Minuta
     * @param integer $id
     * @return mixed
     */
    public function actionPrint($id, $retorno = true) {
        // Modelo da Minuta
        $model = $this->findModel($id);

        // Verifica se o Usuario atual eh dono da Minuta
        if ($model->dono != \Yii::$app->user->identity['cnpj']) {
            $exception = 'Permissão negada.';
            return $this->redirect('site/error');
        }

        // Modelo de dados dos Clientes
        // Usado para Empresa, Remetente, Destinatario e Consignatario
        $cnpj = Yii::$app->user->identity['cnpj'];
        $modelCliente = new Clientes();
        $empresa = $modelCliente->retornaCliente($cnpj);
        $remetente = $modelCliente->retornaCliente($model->remetente);
        $destinatario = $modelCliente->retornaCliente($model->destinatario);
        $consignatario = $modelCliente->retornaCliente($model->consignatario);

        // Modelo da tabela
        $modelTabela = new Tabelas();
        $tabela = $modelTabela->nomeTabela($model->tabela);

        // Define o layout para impressão
        $this->layout = 'minutas-print';

        $conteudoPDF = $this->render('print', [
            'model' => $model,
            'empresa' => $empresa,
            'remetente' => $remetente,
            'destinatario' => $destinatario,
            'consignatario' => $consignatario,
            'tabela' => $tabela,
        ]);

        // Local para se salvar as Minutas em PDF
        $path = Yii::getAlias('@webroot/') . 'pdfs/minutas/' . \Yii::$app->user->identity['cnpj'] . '/LNDSistemas-M' . $model->numero . '.pdf';

        Yii::$app->html2pdf
                ->convert($conteudoPDF)
                ->saveAs($path);

        if (!$retorno) {
            return $path;
        }

        if (is_file($path)) {

            // Set up PDF headers
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="' . '/LNDSistemas-M' . $model->numero . '.pdf' . '"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($path));
            header('Accept-Ranges: bytes');

            // Retorna arquivo PDF
            return readfile($path);
        } else {
            // Retorna arquivo PHP
            return $conteudoPDF;
        }
    }

    public function actionSend($id) {

        // Modelo da Minuta
        $model = $this->findModel($id);

        if (!\Yii::$app->request->isAjax) {

            // Email dos envolvidos
            $envolvidos = new Clientes();
            $remetente = $envolvidos->getEmail($model->remetente);
            $destinatario = $envolvidos->getEmail($model->destinatario);
            $consignatario = $envolvidos->getEmail($model->consignatario);

            return $this->render('send', [
                        'model' => $model,
                        'remetente' => $remetente,
                        'destinatario' => $destinatario,
                        'consignatario' => $consignatario
            ]);
        } else {

            // Cria o arquivo PDF para anexo
            $anexoPDF = $this->actionPrint($id, false);

            // Verifica se o arquivo existe
            if (!is_file($anexoPDF)) {
                return 'Anexo não encontrado!';
            } else {

                // Parametros passados por POST (ajax)
                $EmailDestinatario = explode(',', Yii::$app->request->get('emails'));
                
                // Título do Email
                $titulo = 'LND Sistemas | ' . \Yii::$app->user->identity['empresa'] . ' - Minuta ' . $model->numero;

                $dados['remetente'] = $model->remetente;
                $dados['destinatario'] = $model->destinatario;
                $dados['consignatario'] = $model->consignatario;
                $dados['numero'] = $model->numero;
                
                $EnviaEmail = new EnviaEmail();
                $Envia = $EnviaEmail->Enviar($EmailDestinatario, $titulo, $anexoPDF, $dados);
                
                return $Envia;
                
            }
        }
    }

    /**
     * Finds the Minutas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Minutas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Minutas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
