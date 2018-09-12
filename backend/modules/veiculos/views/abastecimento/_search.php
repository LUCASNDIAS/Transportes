<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\VeiculosAbastecimentoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="veiculos-abastecimento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'veiculo') ?>

    <?= $form->field($model, 'odometro') ?>

    <?= $form->field($model, 'data') ?>

    <?= $form->field($model, 'combustivel') ?>

    <?php // echo $form->field($model, 'posto') ?>

    <?php // echo $form->field($model, 'cheio') ?>

    <?php // echo $form->field($model, 'valor_total') ?>

    <?php // echo $form->field($model, 'litros') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
