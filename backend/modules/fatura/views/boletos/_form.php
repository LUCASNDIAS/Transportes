<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\commands\Basicos;
use backend\assets\FaturaBoletoAsset;

$basicos = new Basicos();
FaturaBoletoAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\modules\fatura\models\FaturaBoleto */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord) {
    $model->nuCPFCNPJ = substr(Yii::$app->user->identity['cnpj'], 0, 8);
    $model->filialCPFCNPJ = substr(Yii::$app->user->identity['cnpj'], 8, 4);
    $model->ctrlCPFCNPJ = substr(Yii::$app->user->identity['cnpj'], -2);
    $model->cdTipoAcesso = 2;
    $model->clubBanco = 0;
    $model->cdTipoContrato = 0;
    $model->nuSequenciaContrato = 0;
    $model->idProduto = '09';
    $model->nuNegociacao = '645600000000000511';
    $model->cdBanco = '237';
    $model->eNuSequenciaContrato = 0;
    $model->tpRegistro = 1;
    $model->cdProduto = 0;
    $model->nuTitulo = 0;
    $model->nuCliente = 'FAT' . $modelFatura->numero;
    $model->dtEmissaoTitulo = date('d/m/Y');
//    $model->dtVencimentoTitulo = $basicos->formataData('form',$modelFatura->vencimento);
    $model->tpVencimento = 0;
    $model->tpProtestoAutomaticoNegativacao = 0;
    $model->prazoProtestoAutomaticoNegativacao = 0;
    $model->controleParticipante = '';
    $model->cdPagamentoParcial = '';
    $model->qtdePagamentoParcial = 0;
    $model->percentualJuros = 0;
    $model->vlJuros = number_format(0.80, 2, '.', '');
    $model->qtdeDiasJuros = 1;
    $model->percentualMulta = number_format(2.00, 2, '.', '');
    $model->vlMulta = 0;
    $model->qtdeDiasMulta = 1;
    $model->percentualDesconto1 = 0;
    $model->vlDesconto1 = 0;
    $model->dataLimiteDesconto1 = '';
    $model->percentualDesconto2 = 0;
    $model->vlDesconto2 = 0;
    $model->dataLimiteDesconto2 = '';
    $model->percentualDesconto3 = 0;
    $model->vlDesconto3 = 0;
    $model->dataLimiteDesconto3 = '';
    $model->prazoBonificacao = 0;
    $model->percentualBonificacao = 0;
    $model->vlBonificacao = 0;
    $model->dtLimiteBonificacao = '';
    $model->vlAbatimento = 0;
    $model->vlIOF = 0;
    $model->nomePagador = substr($modelFatura->sacado0->nome, 0, 70);
    $model->cdIndCpfcnpjPagador = (isset($modelFatura->sacado[13])) ? 2 : 1;
    $model->nuCpfcnpjPagador = $modelFatura->sacado;
    $model->logradouroPagador = $modelFatura->sacado0->endrua;
    $model->nuLogradouroPagador = $modelFatura->sacado0->endnro;
    $model->bairroPagador = $modelFatura->sacado0->endbairro;
    $model->municipioPagador = $modelFatura->sacado0->endcid;
    $model->ufPagador = $modelFatura->sacado0->enduf;
    $model->cepPagador = substr($modelFatura->sacado0->endcep, 0, 5);
    $model->complementoCepPagador = substr($modelFatura->sacado0->endcep, -3);
    $model->cepSacadorAvalista = 0;
    $model->complementoCepSacadorAvalista = 0;
    $model->cdIndCpfcnpjSacadorAvalista = 0;
    $model->nuCpfcnpjSacadorAvalista = 0;

    $tpFatura = ($modelFatura->faturaDocumentos[0]->cte_id) ? 'CTE' : 'MINUTA';
    if ($tpFatura == 'CTE') {
        foreach ($modelFatura->faturaDocumentos as $cte) {
            $valor[] = $cte->cte->vtprest;
        }
    } else {
        foreach ($modelFatura->faturaDocumentos as $minuta) {
            $valor[] = $minuta->minuta->fretetotal;
        }
    }
    $nominal = number_format(array_sum($valor), 2, '.', '');
    $model->vlNominalTitulo = $nominal;
}
?>

<div class="fatura-boleto-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-id-card"></i> Dados Gerais
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">

            <div class="row hide">
                <div class="col-sm-3"><?= $form->field($model, 'nuCPFCNPJ')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'filialCPFCNPJ')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'ctrlCPFCNPJ')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'cdTipoAcesso')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'idProduto')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'nuNegociacao')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'cdBanco')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'tpRegistro')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'clubBanco')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'cdTipoContrato')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'nuSequenciaContrato')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'prazoBonificacao')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'percentualBonificacao')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'vlBonificacao')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'dtLimiteBonificacao')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'eNuSequenciaContrato')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'cdProduto')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'nuTitulo')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'tpProtestoAutomaticoNegativacao')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'prazoProtestoAutomaticoNegativacao')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'controleParticipante')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'cdPagamentoParcial')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'qtdePagamentoParcial')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'percentualDesconto1')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'vlDesconto1')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'dataLimiteDesconto1')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'percentualDesconto2')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'vlDesconto2')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'dataLimiteDesconto2')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'percentualDesconto3')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'vlDesconto3')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'dataLimiteDesconto3')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'vlAbatimento')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'vlIOF')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'cdIndCpfcnpjPagador')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'complementoLogradouroPagador')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'endEletronicoPagador')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'nomeSacadorAvalista')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'logradouroSacadorAvalista')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'nuLogradouroSacadorAvalista')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'complementoLogradouroSacadorAvalista')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'cepSacadorAvalista')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'complementoCepSacadorAvalista')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'bairroSacadorAvalista')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'municipioSacadorAvalista')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'ufSacadorAvalista')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'cdIndCpfcnpjSacadorAvalista')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'nuCpfcnpjSacadorAvalista')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'endEletronicoSacadorAvalista')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'tpVencimento')->textInput() ?></div>
                <div class="col-sm-2"><?= $form->field($model, 'percentualJuros')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-2"><?= $form->field($model, 'vlMulta')->textInput() ?></div>
            </div>

            <div class="row">
                <div class="col-sm-4"><?= $form->field($model, 'nuCliente')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'dtEmissaoTitulo')->textInput([
                        'class' => 'form-control data'
                    ]) ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'dtVencimentoTitulo')->textInput([
                        'class' => 'form-control data'
                    ]) ?></div>
            </div>

            <div class="row">
                <div class="col-sm-6"><?= $form->field($model, 'vlNominalTitulo')->textInput([
                        'class' => 'form-control dinheiro'
                    ]) ?></div>
                <div class="col-sm-6"><?= $form->field($model, 'cdEspecieTitulo')->dropDownList([
                        '02' => 'DM - DUPLICATA DE VENDA MERCANTIL',
                        '01' => 'CH - CHEQUE',
                        '03' => 'DMI - DUPLICATA MERCANTIL POR INDICACAO',
                        '04' => 'DS - DUPLICATA DE PRESTACAO DE SERVICOS',
                        '05' => 'DSI - DUPLICATA PREST. SERVICOS POR INDICACAO',
                        '06' => 'DR - DUPLICATA RURAL',
                        '07' => 'LC - LETRA DE CAMBIO',
                        '08' => 'NCC - NOTA DE CREDITO COMERCIAL',
                        '09' => 'NCE - NOTA DE CREDITO EXPORTACAO',
                        '10' => 'NCI - NOTA DE CREDITO INDUSTRIAL',
                        '11' => 'NCR - NOTA DE CREDITO RURAL',
                        '12' => 'NP - NOTA PROMISSORIA',
                        '13' => 'NPR - NOTA PROMISSORIA RURAL',
                        '14' => 'TM - TRIPLICATA DE VENDA MERCANTIL',
                        '15' => 'TS - TRIPLICATA DE PRESTACAO DE SERVICOS',
                        '16' => 'NS - NOTA DE SERVICO',
                        '17' => 'RC - RECIBO',
                        '18' => 'FAT - FATURA',
                        '19' => 'ND - NOTA DE DEBITO',
                        '20' => 'AP - APOLICE DE SEGURO',
                        '21' => 'ME - MENSALIDADE ESCOLAR',
                        '22' => 'PC - PARCELA DE CONSORCIO',
                        '23' => 'DD - DOCUMENTO DE DIVIDA',
                        '24' => 'CCB - CEDULA DE CREDITO BANCARIO',
                        '25' => 'FI - FINANCIAMENTO',
                        '26' => 'RD - RATEIO DE DESPESAS',
                        '27' => 'DRI - DUPLICATA RURAL INDICACAO',
                        '28' => 'EC - ENCARGOS CONDOMINIAIS',
                        '29' => 'ECI - ENCARGOS CONDOMINIAIS POR INDICACAO31 CC CARTAO DE CREDITO',
                        '32' => 'BDP - BOLETO DE PROPOSTA',
                        '99' => 'OUT - OUTROS'
                    ]) ?></div>
            </div>

            <div class="row">
                <div class="col-sm-3"><?= $form->field($model, 'vlJuros')->textInput([
                        'class' => 'form-control dinheiro'
                    ]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'qtdeDiasJuros')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'percentualMulta')->textInput([
                        'class' => 'form-control dinheiro'
                    ]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'qtdeDiasMulta')->textInput() ?></div>
            </div>

            <div class="row">
                <div class="col-sm-5"><?= $form->field($model, 'nomePagador')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'nuCpfcnpjPagador')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-2"><?= $form->field($model, 'cepPagador')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-2"><?= $form->field($model, 'complementoCepPagador')->textInput(['maxlength' => true]) ?></div>
            </div>

            <div class="row">
                <div class="col-sm-4"><?= $form->field($model, 'logradouroPagador')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-1"><?= $form->field($model, 'nuLogradouroPagador')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'bairroPagador')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'municipioPagador')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-1"><?= $form->field($model, 'ufPagador')->textInput(['maxlength' => true]) ?></div>
            </div>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Gerar e Registrar') : Yii::t('app', 'Atualizar e Registar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
