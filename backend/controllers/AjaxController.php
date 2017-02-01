<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\LoginForm;
use backend\models\ContactForm;
use backend\models\Usuarios;
use yii\data\Pagination;
use yii\db\Command;
use yii\db\Query;
use yii\web\User;
use backend\commands\Basicos;
use yii\db\Expression;
use backend\models\Mensagens;
use backend\models\Tabelas;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use backend\models\Calculos;
use backend\models\Minutas;

class AjaxController extends Controller {
	
	public function behaviors() {
		return [ 
				'access' => [ 
						'class' => AccessControl::className (),
						'only' => [ 
								'logout'
						],
						'rules' => [ 
								[ 
										'actions' => [ 
												'logout' 
										],
										'allow' => true,
										'roles' => [ 
												'@' 
										]
								] 
						] 
				],
				'verbs' => [ 
						'class' => VerbFilter::className (),
						'actions' => [ 
								'logout' => [ 
										'post',
										'get' 
								] 
						] 
				] 
		];
	}
	public function actions() {
		return [ 
				'error' => [ 
						'class' => 'yii\web\ErrorAction' 
				],
				'captcha' => [ 
						'class' => 'yii\captcha\CaptchaAction',
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null 
				] 
		];
	}
	public function actionMsgQtde() {
            
		// Verifica se foi solicitado por Ajax
		if (Yii::$app->request->isAjax) {
	
			// Carrega o Modelo das mensagens
			$msgNova = new Mensagens();
			
			// Retorna a quantidade
			return $msgNova->verificaNovas();
	
		}
	}
	
	
	public function actionMensagens($tipo='')
	{
		// Verifica se foi solicitado por Ajax
		if (Yii::$app->request->isAjax) {
	
			// Carrega o Modelo das mensagens
			$model = new Mensagens();
			
			// Retorna as mensagens
			return $model->listarNovas();
	
		}
	}
	
	public function actionTabelas()
	{
			$tabelas = new Tabelas();
			$listagem = $tabelas->listarNomes();
			
			return Json::encode($listagem);
	
	}
	
	public function actionTeste()
	{
		$tabelas = new Tabelas();
		$listagem = $tabelas->testeAjax();
			
		//$nomes = ArrayHelper::getColumn($listagem, 'nome');
		//return Json::encode($nomes);
		
		$mapa = ArrayHelper::map($listagem, 'id', 'nome');
		return Json::encode($mapa);
	}
	
	public function actionCalculos()
	{
		//$dados = explode('&', $_POST['test']);
		$dados = $_POST['test'];
		$tipo =$_POST['tipo'];
		
		$calculos = new Calculos();
		$calculaFrete = $calculos->calculaFrete($tipo,$dados); // Tem que enviar o array com as variaveis
		
		//return Json::encode($calculaFrete);
		//return Json::encode($dados);
		
		//if(isset($_POST['test'])){
			//$test = explode('&', $_POST['test']);
//		}else{
	//		$test = "Ajax failed";
		//}
		
		return Json::encode($calculaFrete);
		
	}
	
	public function actionSql()
	{
		
		$minutas = new Minutas();
		
		$ultima = $minutas->find()
		->select(['numero'])
		->where([
				'dono' => \Yii::$app->user->identity['cnpj']
				])
		->orderBy('numero DESC')
		->one();
	
		return var_dump($ultima);
	
	}
}
