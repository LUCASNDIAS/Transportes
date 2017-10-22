<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\ordemcoleta\models\OrdemColeta */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ordem Coletas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ordem-coleta-view">

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
            'notasaltura',
            'notaslargura',
            'notascomprimento',
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
