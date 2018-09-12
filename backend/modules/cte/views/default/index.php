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
        <?php
        echo Html::a(Yii::t('app', 'Relatório'), ['/relatorios/default/cte'],
            ['class' => 'btn btn-warning'])
        ?>
        <?php
        echo Html::a(Yii::t('app', 'Download XML'), ['downloads'],
            ['class' => 'btn btn-primary'])
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
                'template' => '{update}&nbsp;&nbsp;{baixar}&nbsp;&nbsp;{email}&nbsp;&nbsp;{print}&nbsp;&nbsp;{send}&nbsp;&nbsp;{download}&nbsp;&nbsp;{cancel}&nbsp;&nbsp;{delete}',
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
                    'download' => function ($url, $model) {
                        return Html::a('<span class="fa fa-file-code-o"></span>',
                                $url,
                                [
                                'title' => Yii::t('app', 'Download XML'),
//                                'target' => '_blank',
                                'data-pjax' => '0'
                        ]);
                    },
                    'cancel' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-remove-circle"></span>',
                                $url,
                                [
                                'title' => Yii::t('app', 'Cancelar CT-e'),
                        ]);
                    },
                    'email' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-envelope"></span>',
                                $url,
                                [
                                'title' => Yii::t('app', 'Enviar por email'),
                                'target' => '_blank',
                                'data-pjax' => '0'
                        ]);
                    },
                    'baixar' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-ok-circle"></span>',
                                $url,
                                [
                                'title' => Yii::t('app', 'Baixar CT-e'),
                                'target' => '_blank',
                                'data-pjax' => '0'
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
                'label' => 'Remetente',
                'format' => 'ntext',
                'attribute'=>'cteRemetente',
                'value' => function($model) {
                    $rem = explode(' ', $model->cteRemetente['nome']);
                    return $rem[0];
                }
            ],
            [
                'label' => 'Destinatário',
                'format' => 'ntext',
                'attribute'=>'cteDestinatario',
                'value' => function($model) {
                    $dest = explode(' ', $model->cteDestinatario['nome']);
                    return $dest[0];
                }
            ],
            [
                'label' => 'Tomador',
                'format' => 'ntext',
                'attribute'=>'cteTomador',
                'value' => function($model) {
                    $toma = explode(' ', $model->cteTomador['nome']);
                    return $toma[0];
                }
            ],
//            [
//                'attribute' => 'Remetente',
//                'value' => 'cteRemetente.nome',
//            ],
//            [
//                'attribute' => 'Destinatario',
//                'value' => 'cteDestinatario.nome',
//            ],
//            [
//                'attribute' => 'Tomador',
//                'value' => 'cteTomador.nome',
//            ],
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
