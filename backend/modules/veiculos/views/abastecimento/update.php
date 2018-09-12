<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\VeiculosAbastecimento */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Abastecimento',
]) . $model->veiculo0['placa'] . ' de ' . $model->data;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Veiculos Abastecimentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="veiculos-abastecimento-update">

    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data,
    ]) ?>

</div>
