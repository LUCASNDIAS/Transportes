<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\fatura\models\FaturaBoleto */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fatura Boletos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-boleto-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fatura_id',
            'nuCPFCNPJ',
            'filialCPFCNPJ',
            'ctrlCPFCNPJ',
            'cdTipoAcesso',
            'clubBanco',
            'cdTipoContrato',
            'nuSequenciaContrato',
            'idProduto',
            'nuNegociacao',
            'cdBanco',
            'eNuSequenciaContrato',
            'tpRegistro',
            'cdProduto',
            'nuTitulo',
            'nuCliente',
            'dtEmissaoTitulo',
            'dtVencimentoTitulo',
            'tpVencimento',
            'vlNominalTitulo',
            'cdEspecieTitulo',
            'tpProtestoAutomaticoNegativacao',
            'prazoProtestoAutomaticoNegativacao',
            'controleParticipante',
            'cdPagamentoParcial',
            'qtdePagamentoParcial',
            'percentualJuros',
            'vlJuros',
            'qtdeDiasJuros',
            'percentualMulta',
            'vlMulta',
            'qtdeDiasMulta',
            'percentualDesconto1',
            'vlDesconto1',
            'dataLimiteDesconto1',
            'percentualDesconto2',
            'vlDesconto2',
            'dataLimiteDesconto2',
            'percentualDesconto3',
            'vlDesconto3',
            'dataLimiteDesconto3',
            'prazoBonificacao',
            'percentualBonificacao',
            'vlBonificacao',
            'dtLimiteBonificacao',
            'vlAbatimento:datetime',
            'vlIOF',
            'nomePagador',
            'logradouroPagador',
            'nuLogradouroPagador',
            'complementoLogradouroPagador',
            'cepPagador',
            'complementoCepPagador',
            'bairroPagador',
            'municipioPagador',
            'ufPagador',
            'cdIndCpfcnpjPagador',
            'nuCpfcnpjPagador',
            'endEletronicoPagador',
            'nomeSacadorAvalista',
            'logradouroSacadorAvalista',
            'nuLogradouroSacadorAvalista',
            'complementoLogradouroSacadorAvalista',
            'cepSacadorAvalista',
            'complementoCepSacadorAvalista',
            'bairroSacadorAvalista',
            'municipioSacadorAvalista',
            'ufSacadorAvalista',
            'cdIndCpfcnpjSacadorAvalista',
            'nuCpfcnpjSacadorAvalista',
            'endEletronicoSacadorAvalista',
            'status',
        ],
    ]) ?>

</div>
