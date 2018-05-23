<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\Veiculos */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Veiculos',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Veiculos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="veiculos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
