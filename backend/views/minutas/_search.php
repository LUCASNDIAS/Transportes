<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MinutasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="minutas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cridt') ?>

    <?= $form->field($model, 'criusu') ?>

    <?= $form->field($model, 'dono') ?>

    <?= $form->field($model, 'numero') ?>

    <?php // echo $form->field($model, 'tipofrete') ?>

    <?php // echo $form->field($model, 'entregalocal') ?>

    <?php // echo $form->field($model, 'pagadorenvolvido') ?>

    <?php // echo $form->field($model, 'pagadorcnpj') ?>

    <?php // echo $form->field($model, 'formapagamento') ?>

    <?php // echo $form->field($model, 'remetente') ?>

    <?php // echo $form->field($model, 'destinatario') ?>

    <?php // echo $form->field($model, 'consignatario') ?>

    <?php // echo $form->field($model, 'notasnumero') ?>

    <?php // echo $form->field($model, 'notasvalor') ?>

    <?php // echo $form->field($model, 'notaspeso') ?>

    <?php // echo $form->field($model, 'notasvolumes') ?>

    <?php // echo $form->field($model, 'notasdimensoes') ?>

    <?php // echo $form->field($model, 'pesoreal') ?>

    <?php // echo $form->field($model, 'pesocubado') ?>

    <?php // echo $form->field($model, 'fretevalor') ?>

    <?php // echo $form->field($model, 'fretepeso') ?>

    <?php // echo $form->field($model, 'taxacoleta') ?>

    <?php // echo $form->field($model, 'taxaentrega') ?>

    <?php // echo $form->field($model, 'taxaseguro') ?>

    <?php // echo $form->field($model, 'taxagris') ?>

    <?php // echo $form->field($model, 'taxadespacho') ?>

    <?php // echo $form->field($model, 'taxaitr') ?>

    <?php // echo $form->field($model, 'taxaextra') ?>

    <?php // echo $form->field($model, 'taxaseccat') ?>

    <?php // echo $form->field($model, 'taxapedagio') ?>

    <?php // echo $form->field($model, 'taxaoutros') ?>

    <?php // echo $form->field($model, 'taxafretevalor') ?>

    <?php // echo $form->field($model, 'desconto') ?>

    <?php // echo $form->field($model, 'fretetotal') ?>

    <?php // echo $form->field($model, 'naturezacarga') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'baixamanifesto') ?>

    <?php // echo $form->field($model, 'manifesto') ?>

    <?php // echo $form->field($model, 'baixacoleta') ?>

    <?php // echo $form->field($model, 'coletadata') ?>

    <?php // echo $form->field($model, 'coletahora') ?>

    <?php // echo $form->field($model, 'coletanome') ?>

    <?php // echo $form->field($model, 'coletaplaca') ?>

    <?php // echo $form->field($model, 'baixaentrega') ?>

    <?php // echo $form->field($model, 'entregadata') ?>

    <?php // echo $form->field($model, 'entregahora') ?>

    <?php // echo $form->field($model, 'entreganome') ?>

    <?php // echo $form->field($model, 'entregadoc') ?>

    <?php // echo $form->field($model, 'baixafatura') ?>

    <?php // echo $form->field($model, 'fatura') ?>

    <?php // echo $form->field($model, 'baixapagamento') ?>

    <?php // echo $form->field($model, 'pagamentorecibo') ?>

    <?php // echo $form->field($model, 'pagamentodata') ?>

    <?php // echo $form->field($model, 'tabela') ?>

    <?php // echo $form->field($model, 'observacoes') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
