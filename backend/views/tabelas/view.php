<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Tabelas */

$this->title = substr($model->nome, 0, 30);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tabelas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tabelas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        
      
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
            	'label' => 'id',
            	'value' => $model->id,
            	'visible' => Yii::$app->user->can('admLND')
            ],
            'cridt',
            [
            	'label'=> 'Criador',
             	'value'=> $model->criusu,
             	'visible' => Yii::$app->user->can('admLND')
           	],
            [
            	'label'=> 'Dono',
             	'value'=> $model->dono,
             	'visible' => Yii::$app->user->can('admLND')
           	],
            'nome',
            'descricao',
        	'valorminimo',
        	'pesominimo',
        	'excedente',
            'fretevalor',
            'despacho',
            'seccat',
            'itr',
            'gris',
            'pedagio',
            'outros',
        ],
    ]) ?>

</div>
