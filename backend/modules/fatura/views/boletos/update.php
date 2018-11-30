<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\fatura\models\FaturaBoleto */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Fatura Boleto',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fatura Boletos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="fatura-boleto-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelFatura' => $modelFatura,
    ]) ?>

</div>
