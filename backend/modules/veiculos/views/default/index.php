<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\veiculos\models\VeiculosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Veiculos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="veiculos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Veiculos'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'marca',
            'modelo',
            'cint',
            'renavam',
            // 'placa',
            // 'tara',
            // 'capkg',
            // 'capm3',
            // 'tpprop',
            // 'tpveic_id',
            // 'tprod_id',
            // 'tpcar_id',
            // 'uf',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
