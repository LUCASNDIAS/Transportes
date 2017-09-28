<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use backend\assets\CteAsset;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model backend\modules\cte\models\Cte */
/* @var $form yii\widgets\ActiveForm */

CteAsset::register($this);
?>

<div class="cte-form">

    <?php
    $form = ActiveForm::begin([
            'id' => 'dynamic-form'
    ]);
    ?>

    <!-- Dados internos -->
    <div class="row hide">
        <div class="col-sm-4"><?=
            $form->field($model, 'cridt')->textInput(['readonly' => true,
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

    <div class="row hide">
        <div class="col-sm-4"><?= $form->field($model, 'cmunenv')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-4"><?= $form->field($model, 'xmunenv')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-4"><?= $form->field($model, 'ufenv')->textInput(['maxlength' => true]) ?></div>
    </div>

    <div class="panel panel-default">

        <!-- Dados Gerais -->
        <div class="panel-heading">
            <i class="fa fa-info-circle"></i> Dados gerais
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-2"><?=
                    $form->field($model, 'modelo')->textInput([
                        'readonly' => true, 'value' => '57'])
                    ?></div>
                <div class="col-sm-2"><?=
                    $form->field($model, 'serie')->textInput([
                        'readonly' => true, 'value' => '1'])
                    ?></div>
                <div class="col-sm-3"><?=
                    $form->field($model, 'dtemissao')->textInput([
                        'readonly' => true, 'value' => date("Y-m-d\TH:i:s")])
                    ?></div>
                <div class="col-sm-3"><?=
                    $form->field($model, 'ambiente')->dropDownList([
                        '1' => 'Produção',
                        '2' => 'Homologação'
                    ])
                    ?></div>
                <div class="col-sm-2"><?=
                    $form->field($model, 'modal')->dropDownList([
                        '01' => 'Rodoviário',
                        '02' => 'Aéreo',
                        '03' => 'Aquaviários'
                    ])
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'tpemis')->dropDownList([
                        '1' => 'Normal',
                        '4' => 'EPEC pela SVC',
                        '5' => 'Contingência FSDA',
                        '7' => 'Autorização pela SVC-RS',
                        '8' => 'Autorização pela SVC-SP'
                    ])
                    ?>
                </div>
                <div class="col-sm-3">
                    <?=
                    $form->field($model, 'tpcte')->dropDownList([
                        '0' => 'Normal',
                        '1' => 'Complemento de valores',
                        '2' => 'Anulação',
                        '3' => 'Substituto'
                    ])
                    ?>
                </div>
                <div class="col-sm-3">
                    <?=
                    $form->field($model, 'tpserv')->dropDownList([
                        '0' => 'Normal',
                        '1' => 'Subcontratação',
                        '2' => 'Redespacho',
                        '3' => 'Redesp. Intermediário',
                        '4' => 'Multimodal'
                    ])
                    ?>
                </div>
                <div class="col-sm-2">
                    <?=
                    $form->field($model, 'forpag')->dropDownList([
                        '2' => 'Faturado / Outros',
                        '0' => 'Pago',
                        '1' => 'A pagar',
                    ])
                    ?> <!-- Deixar como 2 (Outros) -->
                </div>                
            </div>
            <div class="row" id="tpcte">
                <div class="col-sm-12">
                    <?=
                    $form->field($model, 'refcte')->textInput([
                        'maxlength' => true])
                    ?>
                </div>
            </div>

            <div class="row" id="contingencia">
                <div class="col-sm-4"><?= $form->field($model, 'dhcont')->textInput() ?></div>
                <div class="col-sm-8"><?=
                    $form->field($model, 'xjust')->textInput([
                        'maxlength' => true])
                    ?></div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?=
                    $form->field($model, 'retira')->dropDownList([
                        '1' => 'Não',
                        '0' => 'Sim'
                    ])
                    ?></div>
                <div class="col-sm-10"><?=
                    $form->field($model, 'xdetretira')->textInput([
                        'maxlength' => true])
                    ?></div>
                <div class="col-sm-12">
                    <?=
                    $form->field($model, 'numero')->textInput([
                        'maxlength' => true])
                    ?>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default">

        <!-- Dados Gerais -->
        <div class="panel-heading">
            <i class="fa fa-info-circle"></i> Envolvidos / Tabela
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="remetente-nome">Remetente pesq.</label>
                        <?=
                        AutoComplete::widget([
                            'name' => 'remetente-nome',
                            'id' => 'remetente-nome',
                            'clientOptions' => [
                                'source' => $data,
                                'autoFill' => true,
                                'minLength' => 4,
                                'select' => new JsExpression("function( event, ui ) {
                                                                         $('#cte-remetente').val(ui.item.cnpj); // Campo real do remetente
                                                                         $('#cte-remetente').focus();
                                                                         $('#cte-remetente').trigger('change');
                                                                         $('#destinatario-nome').focus();
                                                                                }")
                            ],
                            'options' => [
                                'class' => 'form-control'
                            ],
                        ]);
                        ?>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="col-sm-3">
                    <?=
                    $form->field($model, 'remetente')->textInput(['maxlength' => true,
                        'readonly' => true])
                    ?>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="destinatario-nome">Destinatário pesq.</label>
                        <?=
                        AutoComplete::widget([
                            'name' => 'destinatario-nome',
                            'id' => 'destinatario-nome',
                            'clientOptions' => [
                                'source' => $data,
                                'autoFill' => true,
                                'minLength' => 4,
                                'select' => new JsExpression("function( event, ui ) {
                                                                                    $('#cte-destinatario').val(ui.item.cnpj); // Campo real do remetente
                                                                                    $('#cte-destinatario').focus();
                                                                                    $('#cte-destinatario').trigger('change');
                                                                                    $('#expedidor-nome').focus();
                                                                                }")
                            ],
                            'options' => [
                                'class' => 'form-control'
                            ],
                        ]);
                        ?>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="col-sm-3"><?=
                    $form->field($model, 'destinatario')->textInput([
                        'maxlength' => true, 'readonly' => true])
                    ?></div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="expedidor-nome">Expedidor pesq.</label>
                        <?=
                        AutoComplete::widget([
                            'name' => 'expedidor-nome',
                            'id' => 'expedidor-nome',
                            'clientOptions' => [
                                'source' => $data,
                                'autoFill' => true,
                                'minLength' => 4,
                                'select' => new JsExpression("function( event, ui ) {
                                                                     $('#cte-expedidor').val(ui.item.cnpj); // Campo real do remetente
                                                                     $('#cte-expedidor').focus();
                                                                     $('#cte-expedidor').trigger('change');
                                                                     $('#recebedor-nome').focus();
                                                                            }")
                            ],
                            'options' => [
                                'class' => 'form-control'
                            ],
                        ]);
                        ?>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="col-sm-3">
                    <?=
                    $form->field($model, 'expedidor')->textInput(['maxlength' => true,
                        'readonly' => true])
                    ?>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="control-label" for="recebedor-nome">Recebedor pesq.</label>
                        <?=
                        AutoComplete::widget([
                            'name' => 'recebedor-nome',
                            'id' => 'recebedor-nome',
                            'clientOptions' => [
                                'source' => $data,
                                'autoFill' => true,
                                'minLength' => 4,
                                'select' => new JsExpression("function( event, ui ) {
                                                                                    $('#cte-recebedor').val(ui.item.cnpj); // Campo real do remetente
                                                                                    $('#cte-recebedor').focus();
                                                                                    $('#cte-recebedor').trigger('change');
                                                                                    $('#cte-toma').focus();
                                                                                }")
                            ],
                            'options' => [
                                'class' => 'form-control'
                            ],
                        ]);
                        ?>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="col-sm-3"><?=
                    $form->field($model, 'recebedor')->textInput([
                        'maxlength' => true, 'readonly' => true])
                    ?></div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'toma')->dropDownList(
                        [
                        '0' => 'Remetente',
                        '3' => 'Destinatário',
                        '1' => 'Expedidor',
                        '2' => 'Recebedor',
                        '4' => 'Outros',
                        ],
                        [
                        'prompt' => '-- Selecione --'
                    ])
                    ?>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="recebedor-nome">Tomador pesq.</label>
                        <?=
                        AutoComplete::widget([
                            'name' => 'tomador-nome',
                            'id' => 'tomador-nome',
                            'clientOptions' => [
                                'source' => $data,
                                'autoFill' => true,
                                'minLength' => 4,
                                'select' => new JsExpression("function( event, ui ) {
									    $('#cte-tomador').val(ui.item.cnpj); // Campo real do remetente
								            $('#cte-tomador').focus();
                                                                            $('#cte-tomador').trigger('change');
                                                                            $('#cte-origem').focus();
									}")
                            ],
                            'options' => [
                                'class' => 'form-control'
                            ],
                        ]);
                        ?>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'tomador')->textInput([
                        'maxlength' => true, 'readonly' => true])
                    ?>
                </div>
            </div>


        </div>
    </div>

    <div class="panel panel-default">

        <!-- Dados Gerais -->
        <div class="panel-heading">
            <i class="fa fa-info-circle"></i> Informações Complementares
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <div class="form-group field-cte-origem required">
                    <label class="control-label" for="cte-origem">Origem</label>
                    <?=
                    Html::dropDownList('cte-origem', null, [],
                        ['id' => 'cte-origem', 'class' => 'form-control', 'prompt' => '-- Selecione --']);
                    ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group field-cte-destino required">
                    <label class="control-label" for="cte-destino">Destino</label>
                    <?=
                    Html::dropDownList('cte-destino', null, [],
                        ['id' => 'cte-destino', 'class' => 'form-control', 'prompt' => '-- Selecione --']);
                    ?>
                    <div class="help-block"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6"><?=
                    $form->field($model, 'cfop')->dropDownList([
                        ], ['prompt' => '-- Selecione --'])
                    ?></div>
                <div class="col-sm-6"><?=
                    $form->field($model, 'natop')->textInput([
                        'readonly' => true])
                    ?></div>
            </div>

            <div class="row">
                <div class="col-sm-4"><?=
                    $form->field($model, 'rntrc')->textInput([
                        'maxlength' => true])
                    ?></div>
                <div class="col-sm-4"><?=
                    $form->field($model, 'dprev')->textInput([
                        'class' => 'form-control data'])
                    ?></div>
                <div class="col-sm-4"><?=
                    $form->field($model, 'lota')->dropDownList([
                        '0' => 'Não',
                        '1' => 'Sim'
                    ])
                    ?></div>
            </div>

            <div class="row lotacao">
                <div class="col-sm-6"><?=
                    $form->field($modelCteVeiculo, 'placa')->dropDownList($veiculos,
                        [
                        'prompt' => ' -- Selecione -- '
                    ])
                    ?></div>
                <div class="col-sm-6"><?=
                    $form->field($modelCteMotorista, 'motorista_id')->dropDownList($motoristas,
                        [
                        'prompt' => ' -- Selecione -- '
                    ])
                    ?></div>
            </div>

            <div class="row">
                <div class="col-sm-6"><?=
                    $form->field($model, 'prodpred')->textInput([
                        'maxlength' => true])
                    ?></div>
                <div class="col-sm-6"><?=
                    $form->field($model, 'xoutcat')->textInput([
                        'maxlength' => true])
                    ?></div>
            </div>

        </div>
    </div>


    <div class="hide">
        <table class="table table-hover">
            <tr>
                <td><?= $form->field($model, 'cmunini')->textInput() ?></td>
                <td><?= $form->field($model, 'xmunini')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'ufini')->textInput(['maxlength' => true]) ?></td>
            </tr>
        </table>

        <table class="table table-hover">
            <tr>
                <td><?= $form->field($model, 'cmunfim')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'xmunfim')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'uffim')->textInput(['maxlength' => true]) ?></td>
            </tr>
        </table>
    </div>

    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 99, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsDocumentos[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'tipo',
            'chave',
            'vnf',
            'altura',
            'largura',
            'comprimento',
            'peso',
            'nroma',
            'nped',
            'modelo',
            'serie',
            'ncfop',
            'demi',
        ],
    ]);
    ?>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-road"></i> Documentos
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Nota</button>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body container-items"><!-- widgetContainer -->

            <?php foreach ($modelsDocumentos as $index => $modelDocumentos): ?>

                <div class="item panel panel-default"><!-- widgetBody -->

                    <div class="panel-heading">
                        <span class="panel-title-contato">Nota: <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <?php
                        // necessary for update action.

                        if (!$modelDocumentos->isNewRecord) {

                            echo Html::activeHiddenInput($modelDocumentos,
                                "[{$index}]id");
                        }
                        ?>

                        <div class="row">

                            <div class="col-sm-3">
                                <?=
                                $form->field($modelDocumentos, "[{$index}]tipo")->dropDownList([
                                    'NFE' => 'Nota Fiscal Eletrônica',
                                    'NF' => 'Nota Fiscal',
                                    'OUTROS' => 'Declaração / Outros',
                                    ],
                                    [
                                    'prompt' => ' -- Selecione --',
                                    'class' => 'form-control ctetipo',
                                ])
                                ?>
                            </div>

                            <div class="col-sm-5">
                                <?=
                                $form->field($modelDocumentos, "[{$index}]chave")->textInput([
                                    'class' => 'form-control nfechave'])
                                ?>
                            </div>
                            <div class="col-sm-2">
                                <?=
                                $form->field($modelDocumentos, "[{$index}]vnf")->textInput([
                                    'class' => 'form-control dinheiro'])
                                ?>
                            </div>
                            <div class="col-sm-2">
                                <?=
                                $form->field($modelDocumentos, "[{$index}]peso")->textInput([
                                    'class' => 'form-control peso'])
                                ?>
                            </div>

                        </div>

                        <div class="row notnfe">
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelDocumentos, "[{$index}]nroma")
                                ?>
                            </div>
                            <div class="col-sm-2">
                                <?=
                                $form->field($modelDocumentos, "[{$index}]nped")
                                ?>
                            </div>
                            <div class="col-sm-2">
                                <?=
                                $form->field($modelDocumentos,
                                    "[{$index}]modelo")
                                ?>
                            </div>
                            <div class="col-sm-1">
                                <?=
                                $form->field($modelDocumentos, "[{$index}]serie")
                                ?>
                            </div>
                            <div class="col-sm-2">
                                <?=
                                $form->field($modelDocumentos, "[{$index}]demi")->textInput([
                                    'class' => 'form-control data'])
                                ?>
                            </div>
                            <div class="col-sm-2">
                                <?= $form->field($modelDocumentos,
                                    "[{$index}]ncfop")
                                ?>
                            </div>
                        </div>

                        <!-- end:row -->

                        <!-- Teste aki -->

                       

                        <!-- Até aki -->
                    </div>



                </div>

<?php endforeach; ?>

        </div>

    </div>

<?php DynamicFormWidget::end(); ?>

    <div class="panel panel-default">

        <!-- Dados Gerais -->
        <div class="panel-heading">
            <i class="fa fa-info-circle"></i> Cálculos / Taxas
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-3"><?= $form->field($model, 'pesoreal') ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'pesocubado') ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'notasvalor') ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'notasvolumes') ?></div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'taxaextra')->textInput([
                        'class' => 'form-control dinheiro'])
                    ?>
                </div>
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'desconto')->textInput([
                        'class' => 'form-control dinheiro'])
                    ?>
                </div>
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'tabela_id')->dropDownList([
                        ], ['prompt' => '-- Selecione --', 'id' => 'tabelaAjax'])
                    ?>
                </div>
                <div class="col-sm-12">
<?= $form->field($model, 'vtprest')->textInput(['readonly' => true]) ?>
                </div>
            </div>            
        </div>
    </div>

    <div class="retornoFinal"></div>

    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_con', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items-con', // required: css class selector
        'widgetItem' => '.item-con', // required: css class
        'limit' => 11, // the maximum times, an element can be cloned (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item-con', // css class
        'deleteButton' => '.remove-item-con', // css class
        'model' => $modelsComponentes[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'nome',
            'valor',
        ],
    ]);
    ?>

    <div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-truck"></i> Componentes do frete
            <button type="button" class="pull-right add-item-con btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Componente</button>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body container-items-con"><!-- widgetContainer -->

<?php foreach ($modelsComponentes as $index => $modelComponentes): ?>

                <div class="item-con panel panel-default"><!-- widgetBody -->

                    <div class="panel-heading">
                        <span class="panel-title-condutor">Componente: <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item-con btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <?php
                        // necessary for update action.

                        if (!$modelComponentes->isNewRecord) {

                            echo Html::activeHiddenInput($modelComponentes,
                                "[{$index}]id");
                        }
                        ?>

                        <div class="row">

                            <div class='col-sm-6'>
                                <?=
                                $form->field($modelComponentes, "[{$index}]nome")->textInput([
                                    'maxlength' => true,
                                    'readonly' => true])
                                ?>
                            </div>

                            <div class="col-sm-6">
                                <?=
                                $form->field($modelComponentes,
                                    "[{$index}]valor")->textInput([
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

    <div class="panel panel-default">

        <!-- Dados Gerais -->
        <div class="panel-heading">
            <i class="fa fa-info-circle"></i> Seguro / Tributação
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-4"><?=
                    $form->field($model, 'respseg')->dropDownList([
                        '5' => 'Tomador',
                        '4' => 'Emitente'
                    ])
                    ?></div>
                <div class="col-sm-4"><?=
                    $form->field($model, 'xseg')->textInput([
                        'maxlength' => true])
                    ?></div>
                <div class="col-sm-4"><?=
                    $form->field($model, 'napol')->textInput([
                        'maxlength' => true])
                    ?></div>
            </div>

            <div class="row">

                <div class="col-sm-12">
                    <div class="form-group field-tributo-icms required">
                        <label class="control-label" for="tributo-icms">Classificação Tributária</label>
                        <?=
                        Html::dropDownList('tributo-icms', null,
                            [
                            '00' => 'Tributação Normal do ICMS',
                            '20' => 'Base de Cálculo Reduzida do ICMS',
                            '40' => 'Isenção de ICMS',
                            '41' => 'ICMS Não Tributado',
                            '51' => 'ICMS Não Diferido',
                            '60' => 'ICMS por Substituição Tributária',
                            '90SN' => 'ICMS Simples Nacional',
                            '90' => 'Outros',
                            ],
                            ['id' => 'tributo-icms', 'class' => 'form-control', 'prompt' => '-- Selecione --']);
                        ?>
                        <div class="help-block"></div>
                    </div>
                </div>
            </div>


            <div id="icms">
                <div class="row">
                    <div class="col-sm-3">
                        <?=
                        $form->field($model, 'cst')->textInput(['id' => 'icms-cst',
                            'readonly' => true])
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?=
                        $form->field($model, 'vbc')->textInput([
                            'id' => 'icms-vbc', 'class' => 'form-control imposto',
                            'readonly' => true, 'value' => ($model->isNewRecord)
                                    ? '0.00' : $model['vbc']])
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?=
                        $form->field($model, 'picms')->textInput(['id' => 'icms-picms',
                            'class' => 'form-control imposto',
                            'readonly' => true, 'value' => ($model->isNewRecord)
                                    ? '5.25' : $model['picms']])
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?=
                        $form->field($model, 'vicms')->textInput(['id' => 'icms-vicms',
                            'class' => 'form-control imposto',
                            'readonly' => true, 'value' => ($model->isNewRecord)
                                    ? '0.00' : $model['vicms']])
                        ?>
                    </div>
                    <div class="col-sm-3">
                        <?=
                        $form->field($model, 'predbc')->textInput(['id' => 'icms-predbc',
                            'class' => 'form-control imposto',
                            'readonly' => true, 'value' => ($model->isNewRecord)
                                    ? '0.00' : $model['predbc']])
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <?=
                        $form->field($model, 'vbcstret')->textInput(['id' => 'icms-vbcstret',
                            'class' => 'form-control imposto',
                            'readonly' => true, 'value' => ($model->isNewRecord)
                                    ? '0.00' : $model['vbcstret']])
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?=
                        $form->field($model, 'vicmsret')->textInput(['id' => 'icms-vicmsstret',
                            'class' => 'form-control imposto',
                            'readonly' => true, 'value' => ($model->isNewRecord)
                                    ? '0.00' : $model['vicmsret']])
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?=
                        $form->field($model, 'picmsret')->textInput(['id' => 'icms-picmsstret',
                            'class' => 'form-control imposto',
                            'readonly' => true, 'value' => ($model->isNewRecord)
                                    ? '0.00' : $model['picmsret']])
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?=
                        $form->field($model, 'vcred')->textInput(['id' => 'icms-vcred',
                            'class' => 'form-control imposto',
                            'readonly' => true, 'value' => ($model->isNewRecord)
                                    ? '0.00' : $model['vcred']])
                        ?>
                    </div>
                    <div class="col-sm-3">
<?=
$form->field($model, 'vtottrib')->textInput(['id' => 'icms-vtottrib',
    'class' => 'form-control imposto',
    'readonly' => true])
?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row hide">
    <div class="col-sm-6"><?= $form->field($model, 'vrec')->textInput() ?></div>
    <div class="col-sm-6"><?= $form->field($model, 'vcarga')->textInput() ?></div>
</div>

<div class="form-group">
<?= Html::submitButton(Yii::t('app', 'Emitir'), ['class' => 'btn btn-success'])
?>
</div>

<?php ActiveForm::end(); ?>

</div>
