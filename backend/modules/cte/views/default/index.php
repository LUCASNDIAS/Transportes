<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\cte\models\CteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ctes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cte-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Cte'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dono',
            'cridt',
            'criusu',
            'ambiente',
            // 'chave',
            // 'modelo',
            // 'serie',
            // 'numero',
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
            // 'tomador',
            // 'remetente',
            // 'destinatario',
            // 'recebedor',
            // 'expedidor',
            // 'vtprest',
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
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
