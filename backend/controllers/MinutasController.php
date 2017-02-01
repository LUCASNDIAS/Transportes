<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Minutas;
use backend\models\MinutasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Calculos;
use backend\models\Clientes;
use backend\models\Tabelas;

/**
 * MinutasController implements the CRUD actions for Minutas model.
 */
class MinutasController extends Controller
{
	public $layout = 'main';
	
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        		'access' => [
        				'class' => AccessControl::className (),
        				'only' => [
        						'index'
        				],
        				'rules' => [
        						[
        								'actions' => [
        										'index'
        								],
        								'allow' => true,
        								'roles' => [
        										'@', 'acessoBasico'
        								]
        						]
        				]
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
    public function actionIndex()
    {
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Minutas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Minutas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
        	return $this->redirect(['view', 'id' => $model->id]);
        	
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
        	
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Minutas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    /**
     * Cria o arquivo PDF de uma Minuta
     * @param integer $id
     * @return mixed
     */
    public function actionPrint($id)
    {    	
    	// Modelo da Minuta
    	$model = $this->findModel($id);
    	
    	// Verifica se o Usuario atual eh dono da Minuta
    	if ( $model->dono != \Yii::$app->user->identity['cnpj']) {
    		$exception = 'Permissão negada.';
    		return  $this->redirect('site/error');
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
    	$path = 'pdfs/minutas/' . \Yii::$app->user->identity['cnpj'] .'/LNDSistemas-M' . $id .'.pdf';

    	Yii::$app->html2pdf
    	->convert($conteudoPDF)
    	->saveAs($path);
    	
    	return $conteudoPDF;
    	
    }

    /**
     * Finds the Minutas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Minutas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Minutas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
