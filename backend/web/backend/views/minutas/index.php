<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MinutasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Minutas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="minutas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Minutas'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'cridt',
            'criusu',
            'dono',
            'numero',
            // 'tipofrete',
            // 'entregalocal',
            // 'pagadorenvolvido',
            // 'pagadorcnpj',
            // 'formapagamento',
            // 'remetente',
            // 'destinatario',
            // 'consignatario',
            // 'notasnumero',
            // 'notasvalor',
            // 'notaspeso',
            // 'notasvolumes',
            // 'notasdimensoes',
            // 'pesoreal',
            // 'pesocubado',
            // 'fretevalor',
            // 'fretepeso',
            // 'taxacoleta',
            // 'taxaentrega',
            // 'taxaseguro',
            // 'taxagris',
            // 'taxadespacho',
            // 'taxaitr',
            // 'taxaextra',
            // 'taxaseccat',
            // 'taxapedagio',
            // 'taxaoutros',
            // 'taxafretevalor',
            // 'desconto',
            // 'fretetotal',
            // 'naturezacarga',
            // 'status',
            // 'baixamanifesto',
            // 'manifesto',
            // 'baixacoleta',
            // 'coletadata',
            // 'coletahora',
            // 'coletanome',
            // 'coletaplaca',
            // 'baixaentrega',
            // 'entregadata',
            // 'entregahora',
            // 'entreganome',
            // 'entregadoc',
            // 'baixafatura',
            // 'fatura',
            // 'baixapagamento',
            // 'pagamentorecibo',
            // 'pagamentodata',
            // 'tabela',
            // 'observacoes',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
