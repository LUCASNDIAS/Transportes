<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\assets\MdfeAsset;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\modules\mdfe\models\Mdfe */
/* @var $form yii\widgets\ActiveForm */

MdfeAsset::register($this);
?>

<div class="mdfe-form">

    <?php
    $form = ActiveForm::begin([
            'id' => 'dynamic-form'
    ]);
    ?>

    <!-- Dados internos -->
    <div class="row hiden">
        <div class="col-sm-4"><?= $form->field($model, 'cridt')->textInput(['readonly' => true,
        'value' => ($model->isNewRecord) ? date('Y-m-d') : $model['cridt']]);
    ?></div>
        <div class="col-sm-4"><?=
    $form->field($model, 'criusu')->textInput(['maxlength' => true,
        'readonly' => true, 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['apelido']
                : $model['criusu']]);
    ?></div>
        <div class="col-sm-4"><?=
            $form->field($model, 'dono')->textInput(['maxlength' => true,
                'readonly' => true, 'id' => 'dono', 'value' => ($model->isNewRecord)
                        ? Yii::$app->user->identity['cnpj'] : $model['dono']]);
    ?></div>
    </div>

    <div class="panel panel-default">

        <!-- Dados Gerais -->
        <div class="panel-heading">
            <i class="fa fa-info-circle"></i> Dados gerais
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-2"><?= $form->field($model, 'modelo')->textInput([
                'readonly' => true, 'value' => '58']) ?></div>
                <div class="col-sm-2"><?= $form->field($model, 'serie')->textInput([
                        'readonly' => true, 'value' => '1']) ?></div>
                <div class="col-sm-2"><?= $form->field($model, 'uf')->textInput([
                        'readonly' => true, 'value' => 'MG']) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'dtemissao')->textInput([
                        'readonly' => true, 'value' => date("Y-m-d\TH:i:s")]) ?></div>
                <div class="col-sm-3"><?=
                    $form->field($model, 'ambiente')->dropDownList([
                        '1' => 'Produção',
                        '2' => 'Homologação'
                    ])
                    ?></div>
            </div>
            <div class="row">
                <div class="col-sm-4"><?=
                    $form->field($model, 'tipoemitente')->dropDownList([
                        '1' => 'Prestador de serviço transporte',
                        '2' => 'Transportador de carga própria'
                    ])
                    ?></div>
                <div class="col-sm-3"><?=
                    $form->field($model, 'modalidade')->dropDownList([
                        '1' => 'Rodoviário',
                        '2' => 'Aéreo',
                        '3' => 'Aquaviário',
                        '4' => 'Ferroviário'
                    ])
                    ?></div>
                <div class="col-sm-3"><?=
    $form->field($model, 'formaemissao')->dropDownList([
        '1' => 'Normal',
        '2' => 'Contingência'
    ])
    ?></div>
                <div class="col-sm-2"><?= $form->field($model, 'numero')->textInput([
        'maxlength' => true]) ?></div>
            </div>
            <div class="row">
                <div class="col-sm-6"><?= $form->field($model, 'ufcarga')->dropDownList($ufs,
        ['prompt' => '-- Selecione --']) ?></div>
                <div class="col-sm-6"><?= $form->field($model, 'ufdescarga')->dropDownList($ufs,
        ['prompt' => '-- Selecione --']) ?></div>
            </div>
        </div>
    </div>

<?php
DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items', // required: css class selector
    'widgetItem' => '.item', // required: css class
    'limit' => 25, // the maximum times, an element can be cloned (default 999)
    'min' => 0, // 0 or 1 (default 1)
    'insertButton' => '.add-item', // css class
    'deleteButton' => '.remove-item', // css class
    'model' => $modelsPercurso[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'uf',
    ],
]);
?>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-road"></i> Percurso
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Percurso</button>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body container-items"><!-- widgetContainer -->

<?php foreach ($modelsPercurso as $index => $modelPercurso): ?>

                <div class="item panel panel-default"><!-- widgetBody -->

                    <div class="panel-heading">
                        <span class="panel-title-contato">Percurso: <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

    <?php
    // necessary for update action.

    if (!$modelPercurso->isNewRecord) {

        echo Html::activeHiddenInput($modelPercurso, "[{$index}]id");
    }
    ?>

                        <div class="row">

                            <div class="col-sm-12">
    <?=
    $form->field($modelPercurso, "[{$index}]uf")->dropDownList($ufs,
        [
        'prompt' => '-- Selecione --'
    ])
    ?>
                            </div>

                        </div><!-- end:row -->

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

<?php DynamicFormWidget::end(); ?>

    <div class="row">

        <div class="col-sm-6">
<?php
DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_car', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items-car', // required: css class selector
    'widgetItem' => '.item-car', // required: css class
    'limit' => 50, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-item-car', // css class
    'deleteButton' => '.remove-item-car', // css class
    'model' => $modelsCarregamento[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'cMun',
        'xMun',
    ],
]);
?>

            <div class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-cubes"></i> Local Carga
                    <button type="button" class="pull-right add-item-car btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Município</button>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body container-items-car"><!-- widgetContainer -->

<?php foreach ($modelsCarregamento as $index => $modelCarregamento): ?>

                        <div class="item-car panel panel-default"><!-- widgetBody -->

                            <div class="panel-heading">
                                <span class="panel-title-carregamento">Município: <?= ($index
    + 1) ?></span>
                                <button type="button" class="pull-right remove-item-car btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                                <div class="clearfix"></div>
                            </div>

                            <div class="panel-body">

                                            <?php
                                            // necessary for update action.

                                            if (!$modelCarregamento->isNewRecord) {

                                                echo Html::activeHiddenInput($modelCarregamento,
                                                    "[{$index}]id");
                                            }
                                            ?>

                                <div class="row">

                                    <div class='col-sm-6'>

                                        <div class="form-group">
                                            <label class="control-label" for="tabela-nome">Pesquisa Município</label>
    <?=
    AutoComplete::widget([
        'id' => "carregamento-{$index}-nome",
        'name' => "carregamento-{$index}-nome",
        'clientOptions' => [
            'source' => $municipios,
            'autoFill' => true,
            'minLength' => 2,
            'select' => new JsExpression("function( event, ui ) {
                                                                                         $('#mdfecarregamento-{$index}-cmun').val(ui.item.id); // Campo real do cMun
                                                                                         $('#mdfecarregamento-{$index}-xmun').val(ui.item.value); // Campo real do xMun
                                                                                         $('#mdfecarregamento-{$index}-cmun').focus();
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

                                    <div class="col-sm-2">
    <?=
    $form->field($modelCarregamento, "[{$index}]cMun")->textInput([
        'maxlength' => true,
        'readonly' => true])
    ?>
                                    </div>
                                    <div class="col-sm-4">
                <?=
                $form->field($modelCarregamento, "[{$index}]xMun")->textInput([
                    'maxlength' => true,
                    'readonly' => true])
                ?>
                                    </div>

                                </div><!-- end:row -->

                            </div>

                        </div>

            <?php endforeach; ?>

                </div>

            </div>

<?php DynamicFormWidget::end(); ?>
        </div>

        <div class="col-sm-6">
<?php
DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_des', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items-des', // required: css class selector
    'widgetItem' => '.item-des', // required: css class
    'limit' => 100, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-item-des', // css class
    'deleteButton' => '.remove-item-des', // css class
    'model' => $modelsDescarregamento[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'cMun',
        'xMun',
    ],
]);
?>

            <div class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-dropbox"></i> Local Descarga
                    <button type="button" class="pull-right add-item-des btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Município</button>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body container-items-des"><!-- widgetContainer -->

<?php foreach ($modelsDescarregamento as $index => $modelDescarregamento): ?>

                        <div class="item-des panel panel-default"><!-- widgetBody -->

                            <div class="panel-heading">
                                <span class="panel-title-descarregamento">Município: <?= ($index
    + 1) ?></span>
                                <button type="button" class="pull-right remove-item-des btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                                <div class="clearfix"></div>
                            </div>

                            <div class="panel-body">

                                            <?php
                                            // necessary for update action.

                                            if (!$modelDescarregamento->isNewRecord) {

                                                echo Html::activeHiddenInput($modelDescarregamento,
                                                    "[{$index}]id");
                                            }
                                            ?>

                                <div class="row">

                                    <div class='col-sm-6'>

                                        <div class="form-group">
                                            <label class="control-label" for="tabela-nome">Pesquisa Município</label>
                                        <?=
                                        AutoComplete::widget([
                                            'id' => "descarregamento-{$index}-nome",
                                            'name' => "descarregamento-{$index}-nome",
                                            'clientOptions' => [
                                                'source' => $municipios,
                                                'autoFill' => true,
                                                'minLength' => 2,
                                                'select' => new JsExpression("function( event, ui ) {
                                                                                         $('#mdfedescarregamento-{$index}-cmun').val(ui.item.id); // Campo real do cMun
                                                                                         $('#mdfedescarregamento-{$index}-xmun').val(ui.item.value); // Campo real do xMun
                                                                                         $('#mdfedescarregamento-{$index}-cmun').focus();
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

                                    <div class="col-sm-2">
                <?=
                $form->field($modelDescarregamento, "[{$index}]cMun")->textInput([
                    'maxlength' => true,
                    'readonly' => true])
                ?>
                                    </div>
                                    <div class="col-sm-4">
        <?=
        $form->field($modelDescarregamento, "[{$index}]xMun")->textInput([
            'maxlength' => true,
            'readonly' => true])
        ?>
                                    </div>

                                </div><!-- end:row -->

                            </div>

                        </div>

    <?php endforeach; ?>

                </div>

            </div>

<?php DynamicFormWidget::end(); ?>
        </div>

    </div>

<?php
DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_con', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items-con', // required: css class selector
    'widgetItem' => '.item-con', // required: css class
    'limit' => 10, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-item-con', // css class
    'deleteButton' => '.remove-item-con', // css class
    'model' => $modelsCondutor[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'condutor',
        'xnome',
    ],
]);
?>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-truck"></i> Motoristas
            <button type="button" class="pull-right add-item-con btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Motorista</button>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body container-items-con"><!-- widgetContainer -->

                                <?php foreach ($modelsCondutor as $index => $modelCondutor): ?>

                <div class="item-con panel panel-default"><!-- widgetBody -->

                    <div class="panel-heading">
                        <span class="panel-title-condutor">Motorista: <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item-con btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                                    <?php
                                    // necessary for update action.

                                    if (!$modelCondutor->isNewRecord) {

                                        echo Html::activeHiddenInput($modelCondutor,
                                            "[{$index}]id");
                                    }
                                    ?>

                        <div class="row">

                            <div class='col-sm-4'>

                                <div class="form-group">
                                    <label class="control-label" for="tabela-nome">Pesquisa Motorista</label>
                                <?=
                                AutoComplete::widget([
                                    'id' => "condutor-{$index}-nome",
                                    'name' => "condutor-{$index}-nome",
                                    'clientOptions' => [
                                        'source' => $condutores,
                                        'autoFill' => true,
                                        'minLength' => 2,
                                        'select' => new JsExpression("function( event, ui ) {
                                                                                         $('#mdfecondutor-{$index}-condutor').val(ui.item.id); // Campo real do remetente
                                                                                         $('#mdfecondutor-{$index}-xnome').val(ui.item.value); // Campo real do remetente
                                                                                         $('#mdfecondutor-{$index}-condutor').focus();
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

                            <div class="col-sm-5">
        <?=
        $form->field($modelCondutor, "[{$index}]xnome")->textInput([
            'maxlength' => true,
            'readonly' => true])
        ?>
                            </div>

                            <div class="col-sm-3">
    <?=
    $form->field($modelCondutor, "[{$index}]condutor")->textInput([
        'maxlength' => true,
        'readonly' => true])
    ?>
                            </div>

                        </div><!-- end:row -->

                    </div>

                </div>

    <?php endforeach; ?>

        </div>

    </div>

    <?php DynamicFormWidget::end(); ?>

    <!-- Rodoviário -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-car"></i> Rodoviário
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4"><?= $form->field($model, 'rntrc')->textInput([
        'readonly' => true, 'value' => '10167059']) ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'ciot')->textInput([
        'maxlength' => true]) ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'placa')->textInput([
        'maxlength' => true]) ?></div>
            </div>
        </div>
    </div>

<?php
DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_doc', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items-doc', // required: css class selector
    'widgetItem' => '.item-doc', // required: css class
    'limit' => 2000, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-item-doc', // css class
    'deleteButton' => '.remove-item-doc', // css class
    'model' => $modelsDocumentos[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'tipo',
        'chave',
    ],
]);
?>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-folder-open"></i> Documentos
            <button type="button" class="pull-right add-item-doc btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Documento</button>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body container-items-doc"><!-- widgetContainer -->

<?php foreach ($modelsDocumentos as $index => $modelDocumentos): ?>

                <div class="item-doc panel panel-default"><!-- widgetBody -->

                    <div class="panel-heading">
                        <span class="panel-title-documentos">Documento: <?= ($index
    + 1) ?></span>
                        <button type="button" class="pull-right remove-item-doc btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

    <?php
    // necessary for update action.

    if (!$modelDocumentos->isNewRecord) {

        echo Html::activeHiddenInput($modelDocumentos, "[{$index}]id");
    }
    ?>

                        <div class="row">

                            <div class="col-sm-4">
    <?=
    $form->field($modelDocumentos, "[{$index}]tipo")->dropDownList([
        'CTE' => 'Conhecimento de Transporte (CTe)',
        'NFE' => 'Nota Fiscal Eletrônica (NFe)',
        //'NF' => 'Nota Fiscal (NF mod 1 e A1)'
    ])
    ?>
                            </div>

                            <!--
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label" for="tabela-nome">Pesquisa Documento</label>
    <?= Html::input('text',
        'documento-0-busca', null,
        ['id' => 'documento-0-busca', 'class' => 'form-control']); ?>
                                </div>
                            </div>

                            <div class="col-sm-2">
    <?= Html::a('<i class="fa fa-search"></i> Buscar',
        '#!', ['class' => 'btn btn-app', 'id' => 'documentos-0-click']);
    ?>
                            </div>
                            -->

                            <div class="col-sm-8">
    <?=
    $form->field($modelDocumentos, "[{$index}]chave")->textInput([
        'maxlength' => true,
        'readonly' => false,
    ])
    ?>
                            </div>

                        </div><!-- end:row -->

                    </div>

                </div>

<?php endforeach; ?>

        </div>

    </div>

<?php DynamicFormWidget::end(); ?>

    <div class="panel panel-default">

        <!-- Totalizadores -->
        <div class="panel-heading">
            <i class="fa fa-dollar"></i> Totalizadores
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4"><?= $form->field($model, 'qtdecte')->textInput([
    'value' => '1']) ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'qtdenfe')->textInput() ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'qtdenf')->textInput() ?></div>
            </div>
            <div class="row">
                <div class="col-sm-4"><?= $form->field($model,
    'valormercadoria')->textInput(['class' => 'form-control obrig-din']) ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'unidademedida')->dropDownList([
                    '01' => 'Kg',
                    '02' => 'Ton'
                ]) ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'pesomercadoria')->textInput([
                    'class' => 'form-control obrig-peso'
                ]) ?></div>
            </div>

        </div>

    </div>

    <div class="panel panel-default">

        <!-- Informações adicionais -->
        <div class="panel-heading">
            <i class="fa fa-file-text"></i> Informações adicionais
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6"><?= $form->field($model, 'inffisco')->textarea([
    'maxlength' => true]) ?></div>
                <div class="col-sm-6"><?= $form->field($model,
    'infcontribuinte')->textarea(['maxlength' => true]) ?></div>
            </div>
        </div>

    </div>

    <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Salvar Informações')
            : Yii::t('app', 'Update'),
    ['class' => $model->isNewRecord ? 'btn btn-success btn-valida' : 'btn btn-primary btn-valida',
    'id' => $model->isNewRecord ? 'submitCreate' : 'submitUpdate']); ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
