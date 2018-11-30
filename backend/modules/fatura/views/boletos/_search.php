<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\fatura\models\FaturaBoletoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fatura-boleto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fatura_id') ?>

    <?= $form->field($model, 'nuCPFCNPJ') ?>

    <?= $form->field($model, 'filialCPFCNPJ') ?>

    <?= $form->field($model, 'ctrlCPFCNPJ') ?>

    <?php // echo $form->field($model, 'cdTipoAcesso') ?>

    <?php // echo $form->field($model, 'clubBanco') ?>

    <?php // echo $form->field($model, 'cdTipoContrato') ?>

    <?php // echo $form->field($model, 'nuSequenciaContrato') ?>

    <?php // echo $form->field($model, 'idProduto') ?>

    <?php // echo $form->field($model, 'nuNegociacao') ?>

    <?php // echo $form->field($model, 'cdBanco') ?>

    <?php // echo $form->field($model, 'eNuSequenciaContrato') ?>

    <?php // echo $form->field($model, 'tpRegistro') ?>

    <?php // echo $form->field($model, 'cdProduto') ?>

    <?php // echo $form->field($model, 'nuTitulo') ?>

    <?php // echo $form->field($model, 'nuCliente') ?>

    <?php // echo $form->field($model, 'dtEmissaoTitulo') ?>

    <?php // echo $form->field($model, 'dtVencimentoTitulo') ?>

    <?php // echo $form->field($model, 'tpVencimento') ?>

    <?php // echo $form->field($model, 'vlNominalTitulo') ?>

    <?php // echo $form->field($model, 'cdEspecieTitulo') ?>

    <?php // echo $form->field($model, 'tpProtestoAutomaticoNegativacao') ?>

    <?php // echo $form->field($model, 'prazoProtestoAutomaticoNegativacao') ?>

    <?php // echo $form->field($model, 'controleParticipante') ?>

    <?php // echo $form->field($model, 'cdPagamentoParcial') ?>

    <?php // echo $form->field($model, 'qtdePagamentoParcial') ?>

    <?php // echo $form->field($model, 'percentualJuros') ?>

    <?php // echo $form->field($model, 'vlJuros') ?>

    <?php // echo $form->field($model, 'qtdeDiasJuros') ?>

    <?php // echo $form->field($model, 'percentualMulta') ?>

    <?php // echo $form->field($model, 'vlMulta') ?>

    <?php // echo $form->field($model, 'qtdeDiasMulta') ?>

    <?php // echo $form->field($model, 'percentualDesconto1') ?>

    <?php // echo $form->field($model, 'vlDesconto1') ?>

    <?php // echo $form->field($model, 'dataLimiteDesconto1') ?>

    <?php // echo $form->field($model, 'percentualDesconto2') ?>

    <?php // echo $form->field($model, 'vlDesconto2') ?>

    <?php // echo $form->field($model, 'dataLimiteDesconto2') ?>

    <?php // echo $form->field($model, 'percentualDesconto3') ?>

    <?php // echo $form->field($model, 'vlDesconto3') ?>

    <?php // echo $form->field($model, 'dataLimiteDesconto3') ?>

    <?php // echo $form->field($model, 'prazoBonificacao') ?>

    <?php // echo $form->field($model, 'percentualBonificacao') ?>

    <?php // echo $form->field($model, 'vlBonificacao') ?>

    <?php // echo $form->field($model, 'dtLimiteBonificacao') ?>

    <?php // echo $form->field($model, 'vlAbatimento') ?>

    <?php // echo $form->field($model, 'vlIOF') ?>

    <?php // echo $form->field($model, 'nomePagador') ?>

    <?php // echo $form->field($model, 'logradouroPagador') ?>

    <?php // echo $form->field($model, 'nuLogradouroPagador') ?>

    <?php // echo $form->field($model, 'complementoLogradouroPagador') ?>

    <?php // echo $form->field($model, 'cepPagador') ?>

    <?php // echo $form->field($model, 'complementoCepPagador') ?>

    <?php // echo $form->field($model, 'bairroPagador') ?>

    <?php // echo $form->field($model, 'municipioPagador') ?>

    <?php // echo $form->field($model, 'ufPagador') ?>

    <?php // echo $form->field($model, 'cdIndCpfcnpjPagador') ?>

    <?php // echo $form->field($model, 'nuCpfcnpjPagador') ?>

    <?php // echo $form->field($model, 'endEletronicoPagador') ?>

    <?php // echo $form->field($model, 'nomeSacadorAvalista') ?>

    <?php // echo $form->field($model, 'logradouroSacadorAvalista') ?>

    <?php // echo $form->field($model, 'nuLogradouroSacadorAvalista') ?>

    <?php // echo $form->field($model, 'complementoLogradouroSacadorAvalista') ?>

    <?php // echo $form->field($model, 'cepSacadorAvalista') ?>

    <?php // echo $form->field($model, 'complementoCepSacadorAvalista') ?>

    <?php // echo $form->field($model, 'bairroSacadorAvalista') ?>

    <?php // echo $form->field($model, 'municipioSacadorAvalista') ?>

    <?php // echo $form->field($model, 'ufSacadorAvalista') ?>

    <?php // echo $form->field($model, 'cdIndCpfcnpjSacadorAvalista') ?>

    <?php // echo $form->field($model, 'nuCpfcnpjSacadorAvalista') ?>

    <?php // echo $form->field($model, 'endEletronicoSacadorAvalista') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
