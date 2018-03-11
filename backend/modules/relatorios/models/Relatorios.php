<?php

namespace backend\modules\relatorios\models;

use Yii;
use backend\commands\Basicos;
use backend\modules\financeiro\models\Financeiro;

class Relatorios extends \yii\db\ActiveRecord
{
    public function getReceitas($di, $df, $tipo, $status)
    {

        $basico = new Basicos();
        $di = $basico->formataData('db', $di);
        $df = $basico->formataData('db', $df);

        $model = new Financeiro();
        $query = $model->find()
            ->where(['BETWEEN', 'vencimento', $di, $df])
            ->andWhere(['tipo' => $tipo])
            ->asArray()
            ->all();

        return $query;

    }
}