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

class SiteController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'logout', 'index'
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
                    ],
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

    public function actionIndex() {

        // Carrega a View
        return $this->render('index');
    }

    public function actionUsuarios() {
        $query = Usuarios::find();
        $pagination = new Pagination([
            'defaultPageSize' => 3,
            'totalCount' => $query->count()
        ]);

        $usuarios = $query->orderBy('nome')->offset($pagination->offset)->limit($pagination->limit)->all();

        $command = (new Query ())->select('nome,cnpj,senha')->from('usuarios')->where(array(
                    'or',
                    'id=7',
                    'id=4',
                    'id=8'
                ))->all();

        $Usuario3 = new Usuarios ();
        $teste3 = $Usuario3->find()->select('nome,cnpj,senha')->from('usuarios')->where(array(
                    'or',
                    'id=7',
                    'id=4',
                    'id=8'
                ))->one();

        $Usuario2 = new Usuarios ();
        $cmd = $Usuario2->testeQuery();

        echo '<pre>';
        print_r($teste3);
        echo '</pre>';
        // echo $command->sql;

        $this->view->params ['DadosUsuario'] = Yii::$app->session;
        return $this->render('usuarios', [
                    'usuarios' => $usuarios,
                    'pagination' => $pagination
        ]);
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm ();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
                    'model' => $model
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact() {
        $model = new ContactForm ();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params ['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model
        ]);
    }

    public function actionAbout() {
        return $this->render('about');
    }

    public function actionNaoautorizado() {
        // Verifica se a pessoa está logada
        if (\Yii::$app->user->isGuest) {
            return $this->redirect('@web/site/login');
        }

        // Passa os parametros da sessão para a view
        $this->view->params ['DadosUsuario'] = $_SESSION;

        return $this->render('naoautorizado');
    }

    public function actionTeste() {
        // Passa os parametros da sessão para a view
        $this->view->params ['DadosUsuario'] = Yii::$app->session;

        $Telefone = new Expression('CONCAT("(",TEL.tel_ddd,") ",TEL.tel_nr)');

        $subTelefone = (new Query())
                ->select($Telefone)
                ->from(['TEL' => 'telefones'])
                ->where(new Expression('c.id=TEL.cli_id'))
                ->limit(1);

        $subCid = (new Query())
                ->select('cidade')
                ->from(['CID' => 'cidade'])
                ->where(new Expression('CID.cod=c.cid'))
                ->limit(1);

        $teste = new Query ();
        $query = $teste
                        ->select([
                            'c.id', 'c.nome', 'c.cpf', 'c.cid', 'Cidade' => $subCid, 'Telefone' => $subTelefone
                        ])
                        ->from(['c' => 'cli'])
                        //->join('INNER JOIN','cidade CID','CID.cod = c.cid')
                        //->join('INNER JOIN', 'telefones TEL', 'c.id = TEL.cli_id')
                        ->orderBy('nome')->all();

        // var_dump($query);

        return $this->render('teste', [
                    'query' => $query
        ]);
    }

}
