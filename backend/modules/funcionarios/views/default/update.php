<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Funcionarios */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Funcionarios',
]) . substr($model->nome, 0,30);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Funcionarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="funcionarios-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
