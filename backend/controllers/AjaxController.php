<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\Mensagens;
use backend\models\Tabelas;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use backend\modules\clientes\models\Clientes;
use backend\models\Calculos;
use backend\models\Minutas;
use backend\models\Municipios;
use backend\models\Funcionarios;
use backend\modules\veiculos\models\Veiculos;
use backend\modules\cte\models\Cte;

class AjaxController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => [
                        'post',
                        'get'
                    ]
                ]
            ]
        ];
    }

    public function actions()
    {
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

    public function actionMsgQtde()
    {
        // Verifica se foi solicitado por Ajax
        if (Yii::$app->request->isAjax) {

            // Carrega o Modelo das mensagens
            $msgNova = new Mensagens();

            // Retorna a quantidade
            return $msgNova->verificaNovas();
        }
    }

    public function actionMensagens($tipo = '')
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
        $tabelas  = new Tabelas();
        $listagem = $tabelas->listarNomes();

        return Json::encode($listagem);
    }

    public function actionTabelascomp()
    {
        $tabelas  = new Tabelas();
        $listagem = $tabelas->autoComplete();

        return Json::encode($listagem);
    }

    public function actionMunicipios($filtro = '')
    {
        $municipios = new Municipios();
        $listagem   = $municipios->autoComplete($filtro);

        return Json::encode($listagem);
    }

    public function actionMotoristas()
    {
        $modelPCondutores = new Funcionarios();
        $listagem         = $modelPCondutores->autoComplete();

        return Json::encode($listagem);
    }

    public function actionTabcli($cnpj)
    {

        Yii::$app->response->format = 'json';
        $cliente                    = new Clientes();
        $idcliente                  = $cliente->getIdClientes($cnpj);

        $tbcli = new \backend\models\TabelasClientes();
        $idtab = $tbcli->getTabelasClientes($idcliente);
        $ids   = ArrayHelper::getColumn($idtab, 'tabela_id');

        $tabelas = new Tabelas();
        $tab     = $tabelas->listarTabelas($ids);

        return $tab;
    }

    public function actionCidades($envolvidos)
    {

        // Array com envolvidos
        $clientes = preg_split('/,/', $envolvidos, -1, PREG_SPLIT_NO_EMPTY);

        $cliente = new Clientes();
        $munCli  = $cliente->getCidades($clientes);

        $ibge      = new \backend\models\Municipios;
        $municipio = $ibge->listarNomes($munCli);

        return $municipio;
    }

    public function actionVeiculos()
    {
        $veiculos = new Veiculos();
        $dados    = $veiculos->getVeiculos();

        return Json::encode($dados);
    }

    public function actionCfop($interestadual)
    {

        $cfop  = new \backend\models\Cfop;
        $lista = $cfop->listarNomes($interestadual);

        return $lista;
    }

//    public function actionTeste()
//    {
//////        $tabelas = new Tabelas();
//////        $listagem = $tabelas->testeAjax();
////
////        //$nomes = ArrayHelper::getColumn($listagem, 'nome');
////        //return Json::encode($nomes);
////
////        $mapa = ArrayHelper::map($listagem, 'id', 'nome');
////        return Json::encode($mapa);
//        $basicos = new \backend\commands\Basicos();
//        return $basicos->formataData('db', '28/01/2017');
//    }

    public function actionCalculos()
    {
        //$dados = explode('&', $_POST['test']);
        $dados = $_POST['test'];
        $tipo  = $_POST['tipo'];

        $calculos     = new Calculos();
        // Tem que enviar o array com as variaveis
        $calculaFrete = $calculos->calculaFrete($tipo, $dados);
        //return Json::encode($calculaFrete);
        //return Json::encode($dados);
        //if(isset($_POST['test'])){
        //$test = explode('&', $_POST['test']);
//		}else{
        //		$test = "Ajax failed";
        //}

        return Json::encode($calculaFrete);
    }

    public function actionCalculoscot()
    {
        //$dados = explode('&', $_POST['test']);
        $dados = $_POST['test'];
        $tipo  = $_POST['tipo'];

        $calculos     = new Calculos();
        // Tem que enviar o array com as variaveis
        $calculaFrete = $calculos->calculaFretecot($tipo, $dados);

        return Json::encode($calculaFrete);
    }

    public function actionCalculosoc()
    {
        //$dados = explode('&', $_POST['test']);
        $dados = $_POST['test'];
        $tipo  = $_POST['tipo'];

        $calculos     = new Calculos();
        // Tem que enviar o array com as variaveis
        $calculaFrete = $calculos->calculaFreteoc($tipo, $dados);

        return Json::encode($calculaFrete);
    }

    public function actionCalculoscte()
    {
        //$dados = explode('&', $_POST['test']);
        $dados = $_GET;
        $tipo  = $_GET['tipo'];

        $calculos     = new Calculos();
        // Tem que enviar o array com as variaveis
        $calculaFrete = $calculos->calculaFretecte($tipo, $dados);
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

    public function actionRetornaClientes($term)
    {

        $data = Clientes::find()
            ->select([new \yii\db\Expression("nome as value, CONCAT( `nome`,' | ',`cnpj`) as label, cnpj, endcid")])
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            ->andWhere(['like', 'nome', $term])
            ->orWhere(['like', 'cnpj', $term])
            ->andWhere(['dono' => Yii::$app->user->identity['cnpj']])
            ->asArray()
            ->all();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $data;
    }

    public function actionSelecionaClientes($term)
    {

        $data = Clientes::find()
            ->select([new \yii\db\Expression("cnpj as value, CONCAT( `nome`,' | ',`cnpj`) as label, cnpj, endcid")])
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            ->andWhere(['like', 'nome', $term])
            ->orWhere(['like', 'cnpj', $term])
            ->andWhere(['dono' => Yii::$app->user->identity['cnpj']])
            ->asArray()
            ->all();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $data;
    }

    public function actionGetDocumentos($sacado, $tipo)
    {

        if ($tipo == 'MINUTA') {

            $data = Minutas::find()
                ->select([
                    'id' => 'm.id',
                    'numero' => 'm.numero',
                    'rem' => 'm.remetente',
                    'dest' => 'm.destinatario',
                    'cons' => 'm.consignatario',
                    'valor' => 'm.fretetotal',
                    'docs' => 'm.notasnumero'
                ])
                ->from('minutas m')
                ->leftJoin('fatura_documentos d', 'd.minuta_id = m.id')
                ->where([
                    'm.pagadorcnpj' => $sacado,
                    'm.dono' => Yii::$app->user->identity['cnpj'],
                    'd.minuta_id' => null
                ])
                ->orderBy('numero ASC')
                ->asArray()
                ->all();
        } else {
            
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $data;
    }
}