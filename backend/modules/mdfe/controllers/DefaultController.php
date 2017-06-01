<?php

namespace backend\modules\mdfe\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

/**
 * Default controller for the `mdfe` module
 */
class DefaultController extends Controller
{
    
    public $layout = '@backend/views/layouts/main.php';
    
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

        /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->can('admLND')){
            return var_dump(Yii::$app->user->identity);
        } else {
            return $this->render('index');
        }
    }
}
