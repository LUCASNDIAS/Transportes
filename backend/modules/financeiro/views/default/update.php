<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\financeiro\models\Financeiro */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Financeiro',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Financeiros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="financeiro-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
