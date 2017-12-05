<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\assets\ClientesAsset;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\modules\clientes\models\Clientes */
/* @var $form yii\widgets\ActiveForm */

ClientesAsset::register($this);

?>

<div class="clientes-form">

    <?php
    $form = ActiveForm::begin([
            'id' => 'dynamic-form',
            'enableAjaxValidation' => true,
        ]);
    ?>

    <!-- Dados internos -->
    <div class="row hide">
        <div class="col-sm-3"><?= $form->field($model, 'cridt')->textInput(['readonly' => true,
        'value' => ($model->isNewRecord) ? date('Y-m-d') : $model['cridt']]); ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'criusu')->textInput(['maxlength' => true,
        'readonly' => true, 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['apelido']
                : $model['criusu']]); ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'dono')->textInput(['maxlength' => true,
        'readonly' => true, 'id' => 'dono', 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['cnpj']
                : $model['dono']]); ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'status')->textInput(['maxlength' => true,
        'readonly' => true, 'value' => ($model->isNewRecord) ? '1' : $model['status']]); ?></div>
    </div>

    <!-- Dados Pessoais -->

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-user"></i> Cadastro de Clientes
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-id-card"></i> Dados Pessoais
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">

                    <!-- Nome -->
                    <div class="row">
                        <div class="col-sm-12"><?= $form->field($model, 'nome')->textInput([
        'maxlength' => true])->hint('Razão Social'); ?></div>
                    </div>

                    <!-- CNPJ, IE -->
                    <div class="row">
                        <div class="col-sm-6"><?= $form->field($model, 'cnpj')->textInput([
        'maxlength' => true, 'enableAjaxValidation' => true])->hint('Somente números'); ?></div>
                        <div class="col-sm-6"><?= $form->field($model, 'ie')->textInput([
        'maxlength' => true])->hint('Números ou \'ISENTO\''); ?></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-address-card"></i> Endereço
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-2"><?= $form->field($model, 'endcep')->textInput([
        'maxlength' => true, 'class' => 'form-control cep'])->hint('Somente números'); ?></div>
                        <div class="col-sm-2"><?= Html::a('<i class="fa fa-search"></i> Buscar',
        '#!', ['class' => 'btn btn-app']); ?></div>
                        <div class="col-sm-6"><?= $form->field($model, 'endrua')->textInput([
        'maxlength' => true]); ?></div>
                        <div class="col-sm-2"><?= $form->field($model, 'endnro')->textInput([
        'maxlength' => true]); ?></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5"><?= $form->field($model,
        'endbairro')->textInput(['maxlength' => true]); ?></div>
                        <div class="col-sm-6"><?= $form->field($model, 'endcid')->textInput([
        'maxlength' => true]); ?></div>
                        <div class="col-sm-1"><?= $form->field($model, 'enduf')->textInput([
        'maxlength' => true]); ?></div>
                    </div>

                </div>
            </div>
        </div>
    </div>

<?php
DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items', // required: css class selector
    'widgetItem' => '.item', // required: css class
    'limit' => 6, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-item', // css class
    'deleteButton' => '.remove-item', // css class
    'model' => $modelsContatos[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'nome',
        'email',
        'telefone',
    ],
]);
?>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Contatos
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Contato</button>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body container-items"><!-- widgetContainer -->

                    <?php foreach ($modelsContatos as $index => $modelContatos): ?>

                <div class="item panel panel-default"><!-- widgetBody -->

                    <div class="panel-heading">
                        <span class="panel-title-contato">Contato: <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

    <?php
    // necessary for update action.

    if (!$modelContatos->isNewRecord) {

        echo Html::activeHiddenInput($modelContatos, "[{$index}]id");
    }
    ?>

                        <div class="row">

                            <div class="col-sm-5">
    <?=
    $form->field($modelContatos, "[{$index}]nome")->textInput([
        'maxlength' => true])
    ?>
                            </div>



                            <div class="col-sm-4">

    <?=
    $form->field($modelContatos, "[{$index}]email")->textInput([
        'maxlength' => true])
    ?>

                            </div>

                            <div class="col-sm-3">

    <?=
    $form->field($modelContatos, "[{$index}]telefone")->textInput(['maxlength' => true, 'class' => 'form-control telefone'])
    ?>

                            </div>

                        </div><!-- end:row -->

                    </div>

                </div>

    <?php endforeach; ?>

        </div>

    </div>

    <?php DynamicFormWidget::end(); ?>



    <!-- TABELAS -->
<?php
DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_tab', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items-tab', // required: css class selector
    'widgetItem' => '.item-tab', // required: css class
    'limit' => 99, // the maximum times, an element can be cloned (default 999)
    'min' => 0, // 0 or 1 (default 1)
    'insertButton' => '.add-item-tab', // css class
    'deleteButton' => '.remove-item-tab', // css class
    'model' => $modelsTabelas[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'tabela_id',
    ],
]);
?>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-list"></i> Tabelas
            <button type="button" class="pull-right add-item-tab btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Tabela</button>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body container-items-tab"><!-- widgetContainer -->

                    <?php foreach ($modelsTabelas as $index => $modelTabelas): ?>

                <div class="item-tab panel panel-default"><!-- widgetBody -->

                    <div class="panel-heading">
                        <span class="panel-title-tab">Tabela: <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item-tab btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

    <?php
    // necessary for update action.

    if (!$modelTabelas->isNewRecord) {

        echo Html::activeHiddenInput($modelTabelas, "[{$index}]id");
    }
    ?>

                        <div class='col-sm-8'>

                            <div class="form-group">
                    <label class="control-label" for="tabela-nome">Pesquisa de tabelas</label>
                    <?=
                    AutoComplete::widget([
                        'id' => "tabela-{$index}-nome",
                        'name' => "tabela-{$index}-nome",
                        'clientOptions' => [
                            'source' => $data,
                            'autoFill' => true,
                            'minLength' => 2,
                            'select' => new JsExpression("function( event, ui ) {
                                                                 $('#tabelasclientes-{$index}-tabela_id').val(ui.item.id); // Campo real do remetente
                                                                 $('#tabelasclientes-{$index}-tabela_id').focus();
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

                        <div class="col-sm-4">
        <?=
        $form->field($modelTabelas, "[{$index}]tabela_id")->textInput([
            'maxlength' => true,
            'readonly' => true])
        ?>
                        </div>

                    </div>

                </div>

    <?php endforeach; ?>

        </div>

    </div>

<?php DynamicFormWidget::end(); ?>


    <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Salvar Informações') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-valida' : 'btn btn-primary btn-valida', 'id' => $model->isNewRecord ? 'submitCreate' : 'submitUpdate']); ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
