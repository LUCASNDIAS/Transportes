<?php

namespace backend\modules\relatorios\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use backend\modules\relatorios\models\Relatorios;
use yii\web\HttpException;

/**
 * Default controller for the `relatorios` module
 */
class DefaultController extends Controller
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
                        'roles' => ['admin'],
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
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Receber()
     * Relatório de contas a receber
     * @return string
     */
    public function actionReceber()
    {
        return $this->render('receber');
    }

    /**
     * Pagar()
     * Relatório de contas a pagar
     * @return string
     */
    public function actionPagar()
    {
        return $this->render('pagar');
    }

    /**
     * Balanço()
     * Relatório de contas a pagar
     * @return string
     */
    public function actionBalanco()
    {
        return $this->render('balanco');
    }

    /**
     * GetRelatório()
     * Retorna registros do módulo financeiro
     * @param $di
     * @param $df
     * @param $tipo
     * @param $status
     * @return mixed
     */
    public function actionGetRelatorio($di, $df, $tipo, $status)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new Relatorios();
        $rel   = $model->getFinanceiro($di, $df, $tipo, $status);

        return $rel;
    }
}