<?php

namespace backend\modules\relatorios\controllers;

use yii\web\Controller;
use Yii;
use backend\modules\relatorios\models\Relatorios;

/**
 * Default controller for the `relatorios` module
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionReceber()
    {
        return $this->render('receber');
    }

    public function actionGetRelatorio($di, $df, $tipo, $status)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new Relatorios();
        $rel   = $model->getReceitas($di, $df, $tipo, $status);

        return $rel;
    }
}