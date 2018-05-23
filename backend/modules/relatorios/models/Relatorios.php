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

        $hj = date('Y-m-d');

        $model = new Financeiro();
        $query = $model->find()
            ->where(['BETWEEN', 'vencimento', $di, $df])
            ->andWhere(['tipo' => $tipo])
            ->andWhere(['dono' => Yii::$app->user->identity['cnpj']]);

        if ($status == 'VENCER') {
            $query->andWhere(['>', 'vencimento', $hj]);
            $query->andWhere(['!=', 'status', 'PAGO']);
        }

        if ($status == 'VENCIDO') {
            $query->andWhere(['<', 'vencimento', $hj]);
            $query->andWhere(['!=', 'status', 'PAGO']);
        }

        if ($status == 'PAGO') {
            $query->andWhere(['status' => 'PAGO']);
        }

        $query->orderBy('vencimento ASC');

        $query->asArray();

        $resultado = $query->all();

        return $this->formataRetorno($resultado);
    }

    protected function formataRetorno($resultado)
    {
        $hoje = date('Y-m-d');

        $retorno = $resultado;

        unset($retorno['status']);

        foreach ($resultado as $k => $r) {
            if ($r['status'] == 'PAGO') {
                $retorno[$k]['status'] = 'PAGO';
            } else {
                $venc = $r['vencimento'];

                if ($venc > $hoje) {
                    $retorno[$k]['status'] = 'A VENCER';
                } else {
                    $retorno[$k]['status'] = 'VENCIDO';
                }
            }
        }

        return $retorno;
    }
}