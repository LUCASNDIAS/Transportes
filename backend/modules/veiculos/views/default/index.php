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

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Veiculos'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
//            'id',
            'placa',
            'marca',
            'modelo',
            'cint',
            'renavam',
            // 'tara',
            // 'capkg',
            // 'capm3',
            // 'tpprop',
            // 'tpveic_id',
            // 'tprod_id',
            // 'tpcar_id',
            // 'uf',


        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
