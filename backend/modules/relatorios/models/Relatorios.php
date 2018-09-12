<?php

namespace backend\modules\relatorios\models;

use backend\modules\cte\models\Cte;
use Yii;
use backend\commands\Basicos;
use backend\modules\financeiro\models\Financeiro;
use yii\helpers\ArrayHelper;

class Relatorios extends \yii\db\ActiveRecord
{
    public function getFinanceiro($di, $df, $tipo, $status)
    {

        $basico = new Basicos();
        $di = $basico->formataData('db', $di);
        $df = $basico->formataData('db', $df);

        $hj = date('Y-m-d');

        $model = new Financeiro();
        $query = $model->find()
            ->select([
                'id' => 'id',
                'nome' => 'nome',
                'descricao' => 'descricao',
                'status' => 'status',
                'vencimento' => 'vencimento',
                'valor' => 'valor',
                'tipo' => 'tipo'
            ])
            ->where(['BETWEEN', 'vencimento', $di, $df])
            ->andWhere(['dono' => Yii::$app->user->identity['cnpj']]);

        if ($tipo != 'T') {
            $query->andWhere(['tipo' => $tipo]);
        }


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
        $formatado = $this->formataRetorno($resultado);

        $tipos = ArrayHelper::index($formatado, null, 'tipo');
        foreach ($tipos as $i => $v) {
            $k[$i] = ArrayHelper::map($tipos[$i], 'id', 'valor', ['status']);
        }

        foreach ($k as $a => $b) {
            foreach ($k[$a] as $c => $d) {
                $l[$a][$c] = [
                    'tipo' => ($a == 'D') ? 'DESPESA' : 'RECEITA',
                    'qtde' => count($k[$a][$c]),
                    'total' => array_sum($k[$a][$c])
                ];
            }
        }

        return [
            'lista' => $formatado,
            'totais' => $l
        ];
    }

    public function getCte($di, $df, $status)
    {

        $basico = new Basicos();
        $di = $basico->formataData('db', $di);
        $df = $basico->formataData('db', $df);

        $model = new Cte();
        $query = $model->find()
            ->select([
                'id' => 'c.id',
                'numero' => 'c.numero',
                'emissao' => 'c.cridt',
                'status' => 'c.status',
                'valor' => 'c.vtprest',
                'tomanome' => 'l.nome'
            ])
            ->from('cte c')
            ->innerJoin(['l' => 'clientes'], 'c.tomador = l.cnpj')
            ->where(['BETWEEN', 'c.cridt', $di, $df])
            ->andWhere(['c.dono' => Yii::$app->user->identity['cnpj']])
            ->andWhere(['c.ambiente' => '1'])
            ->andWhere(['!=', 'c.status', 'DELETADO']);

        if ($status != 'TODOS') {
            $query->andWhere(['=', 'c.status', $status]);
        }

        $query->orderBy('c.cridt ASC');

        $query->asArray();

        $resultado = $query->all();

        $grupo = ArrayHelper::map($resultado, 'numero', 'valor', ['status']);
        foreach ($grupo as $i => $v) {
            $k[$i] = [
                'qtde' => count($grupo[$i]),
                'total' => array_sum($grupo[$i])
            ];
        }

        return ['lista' => $resultado,
            'totais' => $k];
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