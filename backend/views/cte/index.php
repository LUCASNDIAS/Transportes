<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ctes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cte-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Cte'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'cridt',
            'criusu',
            'dono',
            'infCTe_chave',
            // 'infCTe_versao',
            // 'ide_cUF',
            // 'ide_cCT',
            // 'ide_CFOP',
            // 'ide_natOp',
            // 'ide_forPag',
            // 'ide_mod',
            // 'ide_serie',
            // 'ide_nCT',
            // 'ide_dhEmi',
            // 'ide_tpImp',
            // 'ide_tpEmis',
            // 'ide_cDV',
            // 'ide_tpAmb',
            // 'ide_tpCTe',
            // 'ide_procEmi',
            // 'ide_verProc',
            // 'ide_refCTe',
            // 'ide_cMunEnv',
            // 'ide_xMunEnv',
            // 'ide_UFEnv',
            // 'ide_modal',
            // 'ide_tpServ',
            // 'ide_cMunIni',
            // 'ide_xMunIni',
            // 'ide_UFIni',
            // 'ide_cMunFim',
            // 'ide_xMunFim',
            // 'ide_UFFim',
            // 'ide_retira',
            // 'ide_xDetRetira',
            // 'ide_dhCont',
            // 'ide_xJust',
            // 'toma',
            // 'tomador',
            // 'emitente',
            // 'remetente',
            // 'destinatario',
            // 'expedidor',
            // 'recebedor',
            // 'vPrest_vTPrest',
            // 'vPrest_vRec',
            // 'comp_xNome',
            // 'comp_vComp',
            // 'tabela',
            // 'taxaextra',
            // 'desconto',
            // 'icms',
            // 'infCarga',
            // 'infQ_cUnid',
            // 'infQ_tpMed',
            // 'infQ_qCarga',
            // 'infNFe',
            // 'infNF',
            // 'seguro',
            // 'infModal_versaoModal',
            // 'rodo',
            // 'veiculo',
            // 'motorista',
            // 'pathXML',
            // 'pathPDF',
            // 'entrega_data',
            // 'entrega_hora',
            // 'entrega_nome',
            // 'entrega_doc',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
