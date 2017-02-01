<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Minutas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="minutas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cridt')->textInput() ?>

    <?= $form->field($model, 'criusu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipofrete')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entregalocal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pagadorenvolvido')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pagadorcnpj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'formapagamento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remetente')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'destinatario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'consignatario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notasnumero')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notasvalor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notaspeso')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notasvolumes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notasdimensoes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pesoreal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pesocubado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fretevalor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fretepeso')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taxacoleta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taxaentrega')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taxaseguro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taxagris')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taxadespacho')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taxaitr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taxaextra')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taxaseccat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taxapedagio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taxaoutros')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taxafretevalor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desconto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fretetotal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'naturezacarga')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'baixamanifesto')->textInput() ?>

    <?= $form->field($model, 'manifesto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'baixacoleta')->textInput() ?>

    <?= $form->field($model, 'coletadata')->textInput() ?>

    <?= $form->field($model, 'coletahora')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coletanome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coletaplaca')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'baixaentrega')->textInput() ?>

    <?= $form->field($model, 'entregadata')->textInput() ?>

    <?= $form->field($model, 'entregahora')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entreganome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entregadoc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'baixafatura')->textInput() ?>

    <?= $form->field($model, 'fatura')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'baixapagamento')->textInput() ?>

    <?= $form->field($model, 'pagamentorecibo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pagamentodata')->textInput() ?>

    <?= $form->field($model, 'tabela')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'observacoes')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
