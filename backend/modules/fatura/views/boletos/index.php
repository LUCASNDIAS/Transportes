<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\fatura\models\FaturaBoletoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Fatura Boletos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-boleto-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Fatura Boleto'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fatura_id',
            'nuCPFCNPJ',
            'filialCPFCNPJ',
            'ctrlCPFCNPJ',
            // 'cdTipoAcesso',
            // 'clubBanco',
            // 'cdTipoContrato',
            // 'nuSequenciaContrato',
            // 'idProduto',
            // 'nuNegociacao',
            // 'cdBanco',
            // 'eNuSequenciaContrato',
            // 'tpRegistro',
            // 'cdProduto',
            // 'nuTitulo',
            // 'nuCliente',
            // 'dtEmissaoTitulo',
            // 'dtVencimentoTitulo',
            // 'tpVencimento',
            // 'vlNominalTitulo',
            // 'cdEspecieTitulo',
            // 'tpProtestoAutomaticoNegativacao',
            // 'prazoProtestoAutomaticoNegativacao',
            // 'controleParticipante',
            // 'cdPagamentoParcial',
            // 'qtdePagamentoParcial',
            // 'percentualJuros',
            // 'vlJuros',
            // 'qtdeDiasJuros',
            // 'percentualMulta',
            // 'vlMulta',
            // 'qtdeDiasMulta',
            // 'percentualDesconto1',
            // 'vlDesconto1',
            // 'dataLimiteDesconto1',
            // 'percentualDesconto2',
            // 'vlDesconto2',
            // 'dataLimiteDesconto2',
            // 'percentualDesconto3',
            // 'vlDesconto3',
            // 'dataLimiteDesconto3',
            // 'prazoBonificacao',
            // 'percentualBonificacao',
            // 'vlBonificacao',
            // 'dtLimiteBonificacao',
            // 'vlAbatimento:datetime',
            // 'vlIOF',
            // 'nomePagador',
            // 'logradouroPagador',
            // 'nuLogradouroPagador',
            // 'complementoLogradouroPagador',
            // 'cepPagador',
            // 'complementoCepPagador',
            // 'bairroPagador',
            // 'municipioPagador',
            // 'ufPagador',
            // 'cdIndCpfcnpjPagador',
            // 'nuCpfcnpjPagador',
            // 'endEletronicoPagador',
            // 'nomeSacadorAvalista',
            // 'logradouroSacadorAvalista',
            // 'nuLogradouroSacadorAvalista',
            // 'complementoLogradouroSacadorAvalista',
            // 'cepSacadorAvalista',
            // 'complementoCepSacadorAvalista',
            // 'bairroSacadorAvalista',
            // 'municipioSacadorAvalista',
            // 'ufSacadorAvalista',
            // 'cdIndCpfcnpjSacadorAvalista',
            // 'nuCpfcnpjSacadorAvalista',
            // 'endEletronicoSacadorAvalista',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
