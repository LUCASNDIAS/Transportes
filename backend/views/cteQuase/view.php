<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Cte */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ctes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cte-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'cridt',
            'criusu',
            'dono',
            'infCTe_chave',
            'infCTe_versao',
            'ide_cUF',
            'ide_cCT',
            'ide_CFOP',
            'ide_natOp',
            'ide_forPag',
            'ide_mod',
            'ide_serie',
            'ide_nCT',
            'ide_dhEmi',
            'ide_tpImp',
            'ide_tpEmis',
            'ide_cDV',
            'ide_tpAmb',
            'ide_tpCTe',
            'ide_procEmi',
            'ide_verProc',
            'ide_refCTe',
            'ide_cMunEnv',
            'ide_xMunEnv',
            'ide_UFEnv',
            'ide_modal',
            'ide_tpServ',
            'ide_cMunIni',
            'ide_xMunIni',
            'ide_UFIni',
            'ide_cMunFim',
            'ide_xMunFim',
            'ide_UFFim',
            'ide_retira',
            'ide_xDetRetira',
            'ide_dhCont',
            'ide_xJust',
            'toma',
            'tomador',
            'emitente',
            'remetente',
            'destinatario',
            'vPrest_vTPrest',
            'vPrest_vRec',
            'comp_xNome',
            'comp_vComp',
            'icms',
            'infCarga',
            'infQ_cUnid',
            'infQ_tpMed',
            'infQ_qCarga',
            'infNFe',
            'infNF',
            'seguro',
            'infModal_versaoModal',
            'rodo',
            'veiculo',
            'motorista',
            'pathXML',
            'pathPDF',
            'entrega_data',
            'entrega_hora',
            'entrega_nome',
            'entrega_doc',
            'status',
        ],
    ]) ?>

</div>
