<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\VeiculosServicoTipo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tipo de serviço',
]) . $model->nome;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Veiculos Servico Tipos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="veiculos-servico-tipo-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
