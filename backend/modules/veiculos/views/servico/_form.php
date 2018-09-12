<?php

use backend\commands\Basicos;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use backend\assets\ServicoAsset;

ServicoAsset::register($this);

$servico = ($model->isNewRecord) ? $tipo_servico : $model->tipo;
$basico = new Basicos();

/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\VeiculosServico */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="veiculos-servico-form">

    <?php $form = ActiveForm::begin([
        'id' => 'dynamic-form'
    ]); ?>

    <!-- Dados internos -->
    <div class="row hided">
        <div class="col-sm-3"><?= $form->field($model, 'cridt')->textInput(['readonly' => true,
                'value' => ($model->isNewRecord) ? date('Y-m-d') : $model['cridt']]); ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'criusu')->textInput(['maxlength' => true,
                'readonly' => true, 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['apelido']
                    : $model['criusu']]); ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'dono')->textInput(['maxlength' => true,
                'readonly' => true, 'id' => 'dono', 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['cnpj']
                    : $model['dono']]); ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'tipo')->textInput(['value' => $servico]) ?></div>
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
                                                                 $('#veiculosservico-veiculo').val(ui.item.id); // Campo real do remetente
                                                                 $('#veiculosservico-veiculo').focus();
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
                <div class="col-sm-2"><?= $form->field($model, 'veiculo')->textInput(['readonly' => true]); ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'odometro')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'data')->textInput(['class' => 'form-control data']) ?></div>
            </div>

        </div>

    </div>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-list"></i> <?= ($servico == 'S') ? 'Tipo de Serviço' : 'Tipo de Despesa'; ?>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            <div class="col-sm-12"><?= $form->field($model, 'tipo_servico')->dropDownList($tipos,[
                    'prompt' => '-- Selecione --'
                ]) ?></div>
        </div>
    </div>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-list"></i> <?= ($servico == 'S') ? 'Serviço' : 'Despesa'; ?>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            <div class="col-sm-6"><?= $form->field($model, 'local')->textInput(['maxlength' => true]) ?></div>
            <div class="col-sm-6"><?= $form->field($model, 'detalhes')->textInput(['maxlength' => true]) ?></div>
        </div>
    </div>

    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_inner',
        'widgetBody' => '.container-dimensao',
        'widgetItem' => '.dimensao-item',
        'limit' => 200,
        'min' => 1,
        'insertButton' => '.add-dimensao',
        'deleteButton' => '.remove-dimensao',
        'model' => $modelsPagamento[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'vencimento',
            'parcela',
            'valor',
        ],
    ]);
    ?>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-road"></i> Pagamento / Parcelas
            <button type="button" class="pull-right add-dimensao btn btn-success btn-xs"><i class="fa fa-plus"></i> Parcela</button>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body container-dimensao"><!-- widgetContainer -->

            <?php foreach ($modelsPagamento as $index => $modelPagamento): ?>

                <div class="dimensao-item panel panel-default"><!-- widgetBody -->

                    <div class="panel-heading">
                        <span class="panel-title-contato">Parcela: <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-dimensao btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <?php
                        // necessary for update action.

                        if (!$modelPagamento->isNewRecord) {

                            $modelPagamento->vencimento = $basico->formataData('form', $modelPagamento->vencimento);

                            echo Html::activeHiddenInput($modelPagamento,
                                "[{$index}]id");
                        }
                        ?>

                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($modelPagamento,
                                    "[{$index}]parcela")->textInput(['class' => 'form-control', 'value' => $index + 1])
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelPagamento,
                                    "[{$index}]valor")->textInput(['class' => 'form-control imposto valorparcela'])
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelPagamento,
                                    "[{$index}]vencimento")->textInput(['class' => 'form-control data'])
                                ?>
                            </div>

                        </div>

                        <!-- end:row -->

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

    <?php DynamicFormWidget::end(); ?>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-list"></i> Totais
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            <div class="col-sm-3"><?= $form->field($model, 'valor_total')->textInput() ?></div>
            <div class="col-sm-2"><?= $form->field($model, 'parcelas')->textInput() ?></div>
            <div class="col-sm-7"><?= $form->field($model, 'observacoes')->textInput(['maxlength' => true]) ?></div>
        </div>
    </div>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-list"></i> Manutenção futura
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            <div class="col-sm-6"><?= $form->field($model, 'prox_odometro')->textInput() ?></div>
            <div class="col-sm-6"><?= $form->field($model, 'prox_data')->textInput(['class' => 'form-control data']) ?></div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
