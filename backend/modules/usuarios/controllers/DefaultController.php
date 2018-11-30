<?php

namespace backend\modules\usuarios\controllers;

use backend\modules\clientes\models\Clientes;
use yii\web\Controller;

/**
 * Default controller for the `usuarios` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $usuario = $this->findUsuario();

        return $this->render('profile',
            [
                'modelUsuario' => $usuario,
            ]);
    }

    /**
     * Finds the Cliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return Clientes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUsuario()
    {
        $model = Clientes::find()
            ->where([
                'cnpj' => \Yii::$app->user->identity->cnpj,
                'dono' => \Yii::$app->user->identity->cnpj,
            ])
            ->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Usuário não encontrado.');
        }
    }

}
