<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\clientes\models\ClientesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clientes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cridt') ?>

    <?= $form->field($model, 'criusu') ?>

    <?= $form->field($model, 'dono') ?>

    <?= $form->field($model, 'nome') ?>

    <?php // echo $form->field($model, 'cnpj') ?>

    <?php // echo $form->field($model, 'ie') ?>

    <?php // echo $form->field($model, 'endrua') ?>

    <?php // echo $form->field($model, 'endnro') ?>

    <?php // echo $form->field($model, 'endbairro') ?>

    <?php // echo $form->field($model, 'endcid') ?>

    <?php // echo $form->field($model, 'enduf') ?>

    <?php // echo $form->field($model, 'endcep') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
