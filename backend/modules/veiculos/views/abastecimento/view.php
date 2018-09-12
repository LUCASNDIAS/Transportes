<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\VeiculosAbastecimento */

$this->title = 'Abastecimento - ' . $model->veiculo0['placa'] . ' de ' . $model->data;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Veiculos Abastecimentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="veiculos-abastecimento-view">

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
//            'id',
            [
                'label' => 'Veículo',
                'format' => 'ntext',
                'attribute'=>'veiculoPlaca',
                'value' => function($model) {
                    $placa = $model->veiculo0['placa'];
                    return $placa;
                }
            ],
            'odometro',
            'data',
            'combustivel',
            'posto',
            [
                'label' => 'Tanque cheio',
                'format' => 'ntext',
                'attribute'=>'tanqueCheio',
                'value' => function($model) {
                    return ($model->cheio) ? 'Sim' : 'Não';
                }
            ],
            'valor_total',
            'litros',
        ],
    ]) ?>

</div>
