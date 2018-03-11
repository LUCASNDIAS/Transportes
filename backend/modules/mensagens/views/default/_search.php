<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\mensagens\models\MensagensSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mensagens-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'data') ?>

    <?= $form->field($model, 'para') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'mensagem') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'dataleitura') ?>

    <?php // echo $form->field($model, 'databaixa') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
