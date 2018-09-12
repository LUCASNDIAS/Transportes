<?php

namespace backend\controllers;

use backend\models\Certificado;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\LoginForm;
use backend\models\ContactForm;
use yii\web\HttpException;

class SiteController extends Controller
{

    /**
     * bejaviors()
     * Controle de acesso
     * @return array
     */
    public function behaviors()
    {
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
                        'allow' => false,
                        'matchCallback' => function ($rule, $action) {
                            throw new HttpException(403, 'Usuário bloqueado! Entre em contato para solucionar este erro.');
                        },
                        'roles' => [
                            'bloqueado'
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

    /**
     * Página principal do sistema
     * Dados do usuário, gráfico financeiro e atalhos para funcionalidades
     * @return string
     */
    public function actionIndex()
    {
        // Carrega a View
        return $this->render('index');
    }

    /**
     * Login()
     * render formulário para login
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        // Verifica se está logado
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // Model de login
        $model = new LoginForm ();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        // Formulário de login
        return $this->render('login', [
            'model' => $model
        ]);
    }

    /**
     * Logout
     * Encerra sessão do usuário e redireciona para o login.
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        // Encerra sessão
        Yii::$app->user->logout();

        // Redireciona para o login
        return $this->goHome();
    }

    /**
     * NaoAutorizado()
     * Ação do usuário não autorizada
     * @return string|\yii\web\Response
     */
    public function actionNaoautorizado()
    {
        // Verifica se a pessoa está logada
        if (\Yii::$app->user->isGuest) {
            return $this->redirect('@web/site/login');
        }

        // Passa os parametros da sessão para a view
        $this->view->params ['DadosUsuario'] = $_SESSION;

        return $this->render('naoautorizado');
    }

    public function actionCertificado()
    {
        $model = new Certificado();
        $verifica = $model->certCheck(Yii::$app->user->identity['cnpj']);

        var_dump($verifica);
    }

}
