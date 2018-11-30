<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\fatura\models\FaturaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Faturas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a(Yii::t('app', 'Gerar Fatura (Minuta)'), ['create'],
            ['class' => 'btn btn-success'])
        ?>
        <?= Html::a(Yii::t('app', 'Gerar Fatura (CT-e)'), ['create-cte'],
            ['class' => 'btn btn-success'])
        ?>
    </p>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{print}&nbsp;&nbsp;{boleto}&nbsp;&nbsp;{send}&nbsp;&nbsp;{delete}',
                'buttons' => [
                    'print' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-print"></span>',
                                $url,
                                [
                                'title' => Yii::t('app', 'Visualizar / Imprimir'),
                                'target' => '_blank',
                                'data-pjax' => '0'
                        ]);
                    },
                    'send' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-send"></span>',
                                $url,
                                [
                                'title' => Yii::t('app', 'Enviar por e-mail'),
                        ]);
                    },
                    'boleto' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-barcode"></span>',
                            $url,
                            [
                                'title' => Yii::t('app', 'Gerar Boleto'),
                                'target' => '_blank',
                                'data-pjax' => '0'
                            ]);
                    },
                ]
            ],
//            ['class' => 'yii\grid\SerialColumn'],
//            'id',
//            'criusu',
//            'cridt',
//            'dono',
            'numero',
            'tipo',
            // 'emissao',
            'vencimento',
            // 'observacoes',
            'sacado',
            // 'pagamento',
            'status',
        ],
    ]);
    ?>
<?php Pjax::end(); ?></div>
