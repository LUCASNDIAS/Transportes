<?php

namespace frontend\modules\portal\controllers;

use yii\web\Controller;

/**
 * Default controller for the `portal` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main';
        return $this->render('index');
    }
}