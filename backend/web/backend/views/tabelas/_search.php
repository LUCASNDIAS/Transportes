<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabelasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tabelas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cridt') ?>

    <?= $form->field($model, 'criusu') ?>

    <?= $form->field($model, 'dono') ?>

    <?= $form->field($model, 'nome') ?>

    <?php // echo $form->field($model, 'descricao') ?>

    <?php // echo $form->field($model, 'fretevalor') ?>

    <?php // echo $form->field($model, 'despacho') ?>

    <?php // echo $form->field($model, 'seccat') ?>

    <?php // echo $form->field($model, 'itr') ?>

    <?php // echo $form->field($model, 'gris') ?>

    <?php // echo $form->field($model, 'pedagio') ?>

    <?php // echo $form->field($model, 'outros') ?>

    <?php // echo $form->field($model, 'valorminimo') ?>

    <?php // echo $form->field($model, 'pesominimo') ?>

    <?php // echo $form->field($model, 'excedente') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
