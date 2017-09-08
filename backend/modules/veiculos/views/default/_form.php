<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\Veiculos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="veiculos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'marca')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'modelo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cint')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'renavam')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tara')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'capkg')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'capm3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tpprop')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tpveic_id')->textInput() ?>

    <?= $form->field($model, 'tprod_id')->textInput() ?>

    <?= $form->field($model, 'tpcar_id')->textInput() ?>

    <?= $form->field($model, 'uf')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
