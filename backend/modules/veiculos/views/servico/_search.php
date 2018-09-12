<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\VeiculosServicoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="veiculos-servico-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cridt') ?>

    <?= $form->field($model, 'criusu') ?>

    <?= $form->field($model, 'dono') ?>

    <?= $form->field($model, 'veiculo') ?>

    <?php // echo $form->field($model, 'odometro') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'tipo_servico') ?>

    <?php // echo $form->field($model, 'valor_total') ?>

    <?php // echo $form->field($model, 'parcelas') ?>

    <?php // echo $form->field($model, 'valor_parcela') ?>

    <?php // echo $form->field($model, 'primeiro_vencimento') ?>

    <?php // echo $form->field($model, 'prox_odometro') ?>

    <?php // echo $form->field($model, 'prox_data') ?>

    <?php // echo $form->field($model, 'local') ?>

    <?php // echo $form->field($model, 'detalhes') ?>

    <?php // echo $form->field($model, 'observacoes') ?>

    <?php // echo $form->field($model, 'financeiro') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
