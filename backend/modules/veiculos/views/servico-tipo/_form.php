<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\ServicoTipoAsset;

ServicoTipoAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\VeiculosServicoTipo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="veiculos-servico-tipo-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-list"></i> Dados gerais
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-sm-5"><?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-5"><?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-2"><?= $form->field($model, 'tipo')->dropDownList([
                        'D' => 'Despesa',
                        'M' => 'Manutenção'
                    ],[
                            'prompt' => '-- Selecione --'
                    ]) ?></div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
