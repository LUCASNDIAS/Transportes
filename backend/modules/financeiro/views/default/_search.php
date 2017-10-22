<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\financeiro\models\FinanceiroSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="financeiro-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'criusu') ?>

    <?= $form->field($model, 'cridt') ?>

    <?= $form->field($model, 'dono') ?>

    <?= $form->field($model, 'nome') ?>

    <?php // echo $form->field($model, 'descricao') ?>

    <?php // echo $form->field($model, 'emissao') ?>

    <?php // echo $form->field($model, 'vencimento') ?>

    <?php // echo $form->field($model, 'valor') ?>

    <?php // echo $form->field($model, 'observacoes') ?>

    <?php // echo $form->field($model, 'cpgto') ?>

    <?php // echo $form->field($model, 'dtpgto') ?>

    <?php // echo $form->field($model, 'sacado') ?>

    <?php // echo $form->field($model, 'fatura') ?>

    <?php // echo $form->field($model, 'tipo') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
