<?php

namespace frontend\modules\elias\controllers;

use yii\web\Controller;

/**
 * Default controller for the `elias` module
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
