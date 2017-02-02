<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\assets\TabelasAsset;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabelasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tabelas');
$this->params['breadcrumbs'][] = $this->title;

TabelasAsset::register($this);
?>
<div class="tabelas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tabelas'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
        	['class' => 'yii\grid\ActionColumn'],
            //'id',
            //'cridt',
            //'criusu',
            //'dono',
            'nome',
			'descricao',
            // 'fretevalor',
            // 'despacho',
            // 'seccat',
            // 'itr',
            // 'gris',
            // 'pedagio',
            // 'outros',
            'valorminimo',
            'pesominimo',
            'excedente',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
