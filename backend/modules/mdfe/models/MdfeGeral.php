<?php

namespace backend\modules\mdfe\models;

use backend\modules\mdfe\models\Mdfe;

class MdfeGeral
{

    public function gerarXml($id)
    {
        // Model do Manifesto
        $model = $this->findModel($id);

        return $model;

    }

    /**
     * Finds the Mdfe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mdfe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mdfe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}