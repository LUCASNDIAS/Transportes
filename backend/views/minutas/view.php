<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Minutas */

$this->title = 'Minuta: ' . str_pad($model->numero, 6, 0, STR_PAD_LEFT);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Minutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="minutas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cridt',
            'criusu',
            'dono',
            'numero',
            'tipofrete',
            'entregalocal',
            'pagadorenvolvido',
            'pagadorcnpj',
            'formapagamento',
            'remetente',
            'destinatario',
            'consignatario',
            'notasnumero',
            'notasvalor',
            'notaspeso',
            'notasvolumes',
            'notasdimensoes',
            'pesoreal',
            'pesocubado',
            'fretevalor',
            'fretepeso',
            'taxacoleta',
            'taxaentrega',
            'taxaseguro',
            'taxagris',
            'taxadespacho',
            'taxaitr',
            'taxaextra',
            'taxaseccat',
            'taxapedagio',
            'taxaoutros',
            'taxafretevalor',
            'desconto',
            'fretetotal',
            'naturezacarga',
            'status',
            'baixamanifesto',
            'manifesto',
            'baixacoleta',
            'coletadata',
            'coletahora',
            'coletanome',
            'coletaplaca',
            'baixaentrega',
            'entregadata',
            'entregahora',
            'entreganome',
            'entregadoc',
            'baixafatura',
            'fatura',
            'baixapagamento',
            'pagamentorecibo',
            'pagamentodata',
            'tabela',
            'observacoes',
        ],
    ]) ?>

</div>
