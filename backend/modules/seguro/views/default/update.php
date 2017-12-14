<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\seguro\models\Seguro */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Seguro',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Seguros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="seguro-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
