<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\ordemcoleta\models\OrdemColeta */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Ordem Coleta',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ordem Coletas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="ordem-coleta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tabela' => $tab
    ]) ?>

</div>
