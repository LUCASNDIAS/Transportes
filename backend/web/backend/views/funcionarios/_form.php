<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Funcionarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="funcionarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endrua')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endbairro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endcep')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endcid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enduf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'naturalidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'datanascimento')->textInput() ?>

    <?= $form->field($model, 'pai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mae')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tel1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tel2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'radio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rg')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cpf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cnhnum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cnhcat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cnhval')->textInput() ?>

    <?= $form->field($model, 'pis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'salario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dtentrada')->textInput() ?>

    <?= $form->field($model, 'criusu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cridt')->textInput() ?>

    <?= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
