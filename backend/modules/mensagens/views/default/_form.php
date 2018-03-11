<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\mensagens\models\Mensagens */
/* @var $form yii\widgets\ActiveForm */

//var_dump($usuarios);
?>

<div class="mensagens-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'data')->textInput(['value' => $model->isNewRecord ? date('Y-m-d') : '']) ?>

    <?= $form->field($model, 'para')->dropDownList($usuarios, ['prompt' => '-- Selecione --']) ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mensagem')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'databaixa')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
