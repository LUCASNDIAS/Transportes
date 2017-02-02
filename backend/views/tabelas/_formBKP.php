<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Tabelas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tabelas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cridt')->textInput() ?>

    <?= $form->field($model, 'criusu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fretevalor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'despacho')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seccat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'itr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gris')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pedagio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'outros')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valorminimo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pesominimo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'excedente')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>