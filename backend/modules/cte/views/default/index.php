<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\assets\CteIndex;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\cte\models\CteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

CteIndex::register($this);

$this->title                   = Yii::t('app', 'Ctes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cte-index">

    <?php Pjax::begin(); ?>
    <?php
    echo $this->render('_search', ['model' => $searchModel, 'data' => $data]);
    ?>

    <p>
        <?php
        echo Html::a(Yii::t('app', 'Create Cte'), ['create'],
            ['class' => 'btn btn-success'])
        ?>
        <?=
        Html::a('<i class="fa fa-search"></i> Pesquisar', '#!',
            ['class' => 'btn btn-app', 'id' => 'btn-pesquisar']);
        ?>
    </p>

    <?php
    if (isset($_GET['msg'])) {
        echo '<pre>' . $_GET['msg'] . '</pre>';
    }
    ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;&nbsp;{print}&nbsp;&nbsp;{send}&nbsp;&nbsp;{cancel}&nbsp;&nbsp;{delete}',
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
                                'title' => Yii::t('app', 'Transmitir para SEFAZ'),
                        ]);
                    },
                    'cancel' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-remove-circle"></span>',
                                $url,
                                [
                                'title' => Yii::t('app', 'Cancelar Manifesto'),
                        ]);
                    },
                ]
            ],
            //'id',
            //'dono',
            //'cridt',
            //'criusu',
            //'ambiente',
            // 'chave',
            // 'modelo',
            // 'serie',
            'numero',
            // 'dtemissao',
            // 'cct',
            // 'cfop',
            // 'natop',
            // 'forpag',
            // 'tpemis',
            // 'tpcte',
            // 'refcte',
            // 'cmunenv',
            // 'xmunenv',
            // 'ufenv',
            // 'modal',
            // 'tpserv',
            // 'cmunini',
            // 'xmunini',
            // 'ufini',
            // 'cmunfim',
            // 'xmunfim',
            // 'uffim',
            // 'retira',
            // 'xdetretira',
            // 'dhcont',
            // 'xjust',
            // 'toma',
            [
                'attribute' => 'Remetente',
                'value' => 'cteRemetente.nome',
            ],
            [
                'attribute' => 'Destinatario',
                'value' => 'cteDestinatario.nome',
            ],
            [
                'attribute' => 'Tomador',
                'value' => 'cteTomador.nome',
            ],
            // 'recebedor',
            // 'expedidor',
            'notaChave',
            'vtprest',
            // 'vrec',
            // 'cst',
            // 'predbc',
            // 'vbv',
            // 'picms',
            // 'vicms',
            // 'vbcstret',
            // 'vicmsret',
            // 'picmsret',
            // 'vcred',
            // 'vtottrib',
            // 'outrauf',
            // 'vcarga',
            // 'predpred',
            // 'xoutcat',
            // 'respseg',
            // 'xseg',
            // 'napol',
            // 'rntrc',
            // 'dprev',
            // 'lota',
            'status',
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
