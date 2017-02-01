<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FuncionariosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="funcionarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'endrua') ?>

    <?= $form->field($model, 'endbairro') ?>

    <?= $form->field($model, 'endcep') ?>

    <?php // echo $form->field($model, 'endcid') ?>

    <?php // echo $form->field($model, 'enduf') ?>

    <?php // echo $form->field($model, 'naturalidade') ?>

    <?php // echo $form->field($model, 'datanascimento') ?>

    <?php // echo $form->field($model, 'pai') ?>

    <?php // echo $form->field($model, 'mae') ?>

    <?php // echo $form->field($model, 'tel1') ?>

    <?php // echo $form->field($model, 'tel2') ?>

    <?php // echo $form->field($model, 'radio') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'rg') ?>

    <?php // echo $form->field($model, 'cpf') ?>

    <?php // echo $form->field($model, 'cnhnum') ?>

    <?php // echo $form->field($model, 'cnhcat') ?>

    <?php // echo $form->field($model, 'cnhval') ?>

    <?php // echo $form->field($model, 'pis') ?>

    <?php // echo $form->field($model, 'cargo') ?>

    <?php // echo $form->field($model, 'salario') ?>

    <?php // echo $form->field($model, 'dtentrada') ?>

    <?php // echo $form->field($model, 'criusu') ?>

    <?php // echo $form->field($model, 'cridt') ?>

    <?php // echo $form->field($model, 'img') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
