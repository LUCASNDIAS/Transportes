<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cte-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cridt') ?>

    <?= $form->field($model, 'criusu') ?>

    <?= $form->field($model, 'dono') ?>

    <?= $form->field($model, 'infCTe_chave') ?>

    <?php // echo $form->field($model, 'infCTe_versao') ?>

    <?php // echo $form->field($model, 'ide_cUF') ?>

    <?php // echo $form->field($model, 'ide_cCT') ?>

    <?php // echo $form->field($model, 'ide_CFOP') ?>

    <?php // echo $form->field($model, 'ide_natOp') ?>

    <?php // echo $form->field($model, 'ide_forPag') ?>

    <?php // echo $form->field($model, 'ide_mod') ?>

    <?php // echo $form->field($model, 'ide_serie') ?>

    <?php // echo $form->field($model, 'ide_nCT') ?>

    <?php // echo $form->field($model, 'ide_dhEmi') ?>

    <?php // echo $form->field($model, 'ide_tpImp') ?>

    <?php // echo $form->field($model, 'ide_tpEmis') ?>

    <?php // echo $form->field($model, 'ide_cDV') ?>

    <?php // echo $form->field($model, 'ide_tpAmb') ?>

    <?php // echo $form->field($model, 'ide_tpCTe') ?>

    <?php // echo $form->field($model, 'ide_procEmi') ?>

    <?php // echo $form->field($model, 'ide_verProc') ?>

    <?php // echo $form->field($model, 'ide_refCTe') ?>

    <?php // echo $form->field($model, 'ide_cMunEnv') ?>

    <?php // echo $form->field($model, 'ide_xMunEnv') ?>

    <?php // echo $form->field($model, 'ide_UFEnv') ?>

    <?php // echo $form->field($model, 'ide_modal') ?>

    <?php // echo $form->field($model, 'ide_tpServ') ?>

    <?php // echo $form->field($model, 'ide_cMunIni') ?>

    <?php // echo $form->field($model, 'ide_xMunIni') ?>

    <?php // echo $form->field($model, 'ide_UFIni') ?>

    <?php // echo $form->field($model, 'ide_cMunFim') ?>

    <?php // echo $form->field($model, 'ide_xMunFim') ?>

    <?php // echo $form->field($model, 'ide_UFFim') ?>

    <?php // echo $form->field($model, 'ide_retira') ?>

    <?php // echo $form->field($model, 'ide_xDetRetira') ?>

    <?php // echo $form->field($model, 'ide_dhCont') ?>

    <?php // echo $form->field($model, 'ide_xJust') ?>

    <?php // echo $form->field($model, 'toma') ?>

    <?php // echo $form->field($model, 'tomador') ?>

    <?php // echo $form->field($model, 'emitente') ?>

    <?php // echo $form->field($model, 'remetente') ?>

    <?php // echo $form->field($model, 'destinatario') ?>

    <?php // echo $form->field($model, 'vPrest_vTPrest') ?>

    <?php // echo $form->field($model, 'vPrest_vRec') ?>

    <?php // echo $form->field($model, 'comp_xNome') ?>

    <?php // echo $form->field($model, 'comp_vComp') ?>

    <?php // echo $form->field($model, 'icms') ?>

    <?php // echo $form->field($model, 'infCarga') ?>

    <?php // echo $form->field($model, 'infQ_cUnid') ?>

    <?php // echo $form->field($model, 'infQ_tpMed') ?>

    <?php // echo $form->field($model, 'infQ_qCarga') ?>

    <?php // echo $form->field($model, 'infNFe') ?>

    <?php // echo $form->field($model, 'infNF') ?>

    <?php // echo $form->field($model, 'seguro') ?>

    <?php // echo $form->field($model, 'infModal_versaoModal') ?>

    <?php // echo $form->field($model, 'rodo') ?>

    <?php // echo $form->field($model, 'veiculo') ?>

    <?php // echo $form->field($model, 'motorista') ?>

    <?php // echo $form->field($model, 'pathXML') ?>

    <?php // echo $form->field($model, 'pathPDF') ?>

    <?php // echo $form->field($model, 'entrega_data') ?>

    <?php // echo $form->field($model, 'entrega_hora') ?>

    <?php // echo $form->field($model, 'entrega_nome') ?>

    <?php // echo $form->field($model, 'entrega_doc') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
