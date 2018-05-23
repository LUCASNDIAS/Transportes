<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MinutasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Minutas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="minutas-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Minutas'), ['create'],
            ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            // ['class' => 'yii\grid\ActionColumn'],
                ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}&nbsp;&nbsp;{print}&nbsp;&nbsp;{send}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
                'buttons' => [
                    'print' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-print"></span>',
                                $url,
                                [
                                'title' => Yii::t('app', 'PDF / Impressão'),
                                'target' => '_blank',
                                'data-pjax' => '0'
                        ]);
                    },
                    'send' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-send"></span>',
                                $url,
                                [
                                'title' => Yii::t('app', 'Enviar por email'),
                        ]);
                    },
                ]
            ],
            //'id',
            //'cridt',
            //'criusu',
            //'dono',
            'numero',
            // 'tipofrete',
            // 'entregalocal',
            // 'pagadorenvolvido',
            // 'pagadorcnpj',
            // 'formapagamento',
            //'remetente',
            ['label' => 'Remetente',
                'value' => function($data) {
                    $parametro['cnpj'] = $data->remetente;
                    return $data->stringDataGrid('cliente', $parametro);
                }],
            //'destinatario',
            ['label' => 'Destinatário',
                'value' => function($data) {
                    $parametro['cnpj'] = $data->destinatario;
                    return $data->stringDataGrid('cliente', $parametro);
                }],
            //'consignatario',
            ['label' => 'Consignatário',
                'value' => function($data) {
                    $parametro['cnpj'] = $data->consignatario;
                    return $data->stringDataGrid('cliente', $parametro);
                }],
            'notasnumero',
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
            'fretetotal',
            // 'naturezacarga',
            'status',
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
        ],
    ]);
    ?>
<?php Pjax::end(); ?></div>
