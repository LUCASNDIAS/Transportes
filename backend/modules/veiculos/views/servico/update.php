<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\VeiculosServico */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Veiculos Servico',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Veiculos Servicos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="veiculos-servico-update">

    <?= $this->render('_form', [
        'model' => $model,
        'data'  => $data,
        'tipos' => $tipos,
        'modelsPagamento' => $modelsPagamento
    ]) ?>

</div>
