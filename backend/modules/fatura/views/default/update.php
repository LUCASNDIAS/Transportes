<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\fatura\models\Fatura */

$this->title                   = Yii::t('app', 'Update {modelClass}: ',
        [
        'modelClass' => 'Fatura',
    ]).$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faturas'), 'url' => [
        'index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="fatura-update">

    <?=
    $this->render('_form',
        [
        'model' => $model,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ])
    ?>

</div>
