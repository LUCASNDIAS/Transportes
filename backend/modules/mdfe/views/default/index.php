<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\mdfe\models\MdfeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mdves');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mdfe-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Mdfe'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{print}&nbsp;&nbsp;{send}&nbsp;&nbsp;{cancel}&nbsp;&nbsp;{delete}',
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
            //'chave',
            // 'modelo',
            // 'serie',
            'numero',
            'dtemissao',
            // 'dtinicio',
            // 'uf',
            // 'tipoemitente',
            // 'modalidade',
            // 'formaemissao',
            'ufcarga',
            'ufdescarga',
            // 'rntrc',
            // 'ciot',
            'placa',
            // 'qtdecte',
            // 'qtdenfe',
            // 'qtdenf',
            // 'valormercadoria',
            // 'unidademedida',
            // 'pesomercadoria',
            // 'inffisco',
            // 'infcontribuinte',
            // 'status',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
