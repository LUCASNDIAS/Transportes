<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use backend\assets\ServicoAsset;

ServicoAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\VeiculosAbastecimento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="veiculos-abastecimento-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Dados internos -->
    <div class="row hide">
        <div class="col-sm-4"><?= $form->field($model, 'cridt')->textInput(['readonly' => true,
                'value' => ($model->isNewRecord) ? date('Y-m-d') : $model['cridt']]); ?></div>
        <div class="col-sm-4"><?= $form->field($model, 'criusu')->textInput(['maxlength' => true,
                'readonly' => true, 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['apelido']
                    : $model['criusu']]); ?></div>
        <div class="col-sm-4"><?= $form->field($model, 'dono')->textInput(['maxlength' => true,
                'readonly' => true, 'id' => 'dono', 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['cnpj']
                    : $model['dono']]); ?></div>
    </div>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-list"></i> Dados gerais
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">

            <div class="row">
                <div class='col-sm-4'>

                    <div class="form-group">
                        <label class="control-label" for="tabela-nome">Pesquisa de veículos</label>
                        <?=
                        AutoComplete::widget([
                            'id' => "veiculosabastecimento-placa",
                            'name' => "veiculosabastecimento-placa",
                            'clientOptions' => [
                                'source' => $data,
                                'autoFill' => true,
                                'minLength' => 2,
                                'select' => new JsExpression("function( event, ui ) {
                                                                 $('#veiculosabastecimento-veiculo').val(ui.item.id); // Campo real do remetente
                                                                 $('#veiculosabastecimento-veiculo').focus();
                                                                 ultimoKM(ui.item.id);
									}")
                            ],
                            'options' => [
                                'class' => 'form-control ui-autocomplete-input',
                                'autocomplete' => 'off'
                            ],
                        ]);
                        ?>
                        <p class="help-block help-block-error"></p>
                    </div>

                </div>
                <div class="col-sm-3"><?= $form->field($model, 'veiculo')->textInput(['readonly' => true]); ?></div>
                <div class="col-sm-5"><?= $form->field($model, 'data')->textInput(['class' => 'form-control data']) ?></div>
            </div>

            <div class="row">
                <div class="col-sm-3"><?= $form->field($model, 'odometro')->textInput()->hint('Último: ') ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'posto')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'combustivel')->dropDownList([
                        'ALCOOL' => 'Álcool',
                        'DIESEL' => 'Diesel',
                        'GASOLINA' => 'Gasolina',
                        'GNV' => 'GNV'
                    ], [
                        'prompt' => '-- Selecione --'
                    ]) ?></div>
                <div class="col-sm-2"><?= $form->field($model, 'cheio')->dropDownList([
                        '0' => 'Não',
                        '1' => 'Sim'
                    ], [
                        'prompt' => '-- Selecione --'
                    ]) ?></div>
            </div>
            <div class="row">
                <div class="col-sm-6"><?= $form->field($model, 'valor_total')->textInput(['class' => 'form-control dinheiro']) ?></div>
                <div class="col-sm-6"><?= $form->field($model, 'litros')->textInput(['class' => 'form-control imposto']) ?></div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
