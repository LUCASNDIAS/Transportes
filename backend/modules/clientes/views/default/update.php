<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\clientes\models\Clientes */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Clientes',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="clientes-update">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= $this->render('_form', [
        'model' => $model,
        'modelsContatos' => $modelsContatos,
        'modelsTabelas' => $modelsTabelas,
        'data' => $data,
    ]) ?>

</div>
