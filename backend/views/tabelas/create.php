<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Tabelas */

$this->title = Yii::t('app', 'Create Tabelas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tabelas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tabelas-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
