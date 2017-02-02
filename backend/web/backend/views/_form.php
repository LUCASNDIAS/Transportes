<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Clientes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clientes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cridt')->textInput() ?>

    <?= $form->field($model, 'criusu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cnpj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ie')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endrua')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endnro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endbairro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endcid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enduf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endcep')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'responsaveis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefones')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emails')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tabelas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
