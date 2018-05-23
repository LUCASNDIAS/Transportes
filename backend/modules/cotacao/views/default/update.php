<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\cotacao\models\Cotacao */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cotacao',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cotacaos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cotacao-update">

    <?= $this->render('_form', [
        'model' => $model,
        'tabela' => $tabela,
    ]) ?>

</div>
