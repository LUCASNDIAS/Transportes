<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use backend\assets\CteAsset;
use backend\models\Clientes;

CteAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\models\Cte */
/* @var $form yii\widgets\ActiveForm */

// Chave na hora de Salvar (escrever na model before save)
// Formato Keys::buildKey($cUF, $ano, $mes, $cnpj, $mod, $serie, $numero, $tpEmis, $codigo);
// Exemplo $chaveCTe = Keys::buildKey('31', '17', '02', '11095658000140', '56', '001', '78', '1', '');
// var_dump($data);
?>

<div class="cte-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'cte-form'
    ]);
    ?>

    <table class="table table-hover">
        <tr>
            <td>Controle Interno</td>
        </tr>
    </table>
    <table class="table table-hover">
        <tr>
            <td><?= $form->field($model, 'cridt')->textInput(['readonly' => true, 'value' => ($model->isNewRecord) ? date('Y-m-d') : $model['cridt']]); ?></td>
            <td><?= $form->field($model, 'criusu')->textInput(['maxlength' => true, 'readonly' => true, 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['apelido'] : $model['criusu']]); ?></td>
            <td><?= $form->field($model, 'dono')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'dono', 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['cnpj'] : $model['dono']]); ?></td>
        </tr>
    </table>

    <table class="table table-hover">
        <tr>
            <td><?=
                $form->field($model, 'ide_tpImp')->dropDownList([
                    '1' => 'Retrato', '2' => 'Paisagem'
                ])
                ?></td>
            <td>
                <?=
                $form->field($model, 'ide_tpEmis')->dropDownList([
                    '1' => 'Normal', '4' => 'EPEC pela SCV', '5' => 'Contingência'
                ])
                ?>
            </td>
            <td>
                <?=
                $form->field($model, 'ide_tpAmb')->dropDownList([
                    '1' => 'Produção', '2' => 'Homologação'
                ])
                ?>
            </td>
            <td>
                <?=
                $form->field($model, 'ide_tpCTe')->dropDownList([
                    '0' => 'Normal', '1' => 'Complemento', '2' => 'Anulação', '3' => 'Substituto'
                ])
                ?>
            </td>
        </tr>
    </table>

    <div id="tpcte">
        <table class="table table-hover">
            <tr>
                <td><?= $form->field($model, 'ide_refCTe')->textInput() ?></td>
            </tr>
        </table>
    </div>

    <div id="contingencia">
        <table class="table table-hover">
            <tr>
                <td>
                    <?= $form->field($model, 'ide_dhCont')->textInput(['value' => $model->isNewRecord ? date('Y-m-d\TH:i:s') : $model->ide_dhCont]) ?>
                </td>
                <td>
<?= $form->field($model, 'ide_xJust')->textInput(['maxlength' => true]) ?>
                </td>
            </tr>
        </table>
    </div>

      <table class="table table-hover">
        <tr>
            <td><?=
                $form->field($model, 'ide_modal')->dropDownList(
                        [
                            '01' => 'Rodoviário',
                            '02' => 'Aéreo',
                            '03' => 'Aquaviário'
                ])
                ?></td>
            <td>
                <?=
                $form->field($model, 'ide_tpServ')->dropDownList(
                        [
                            '0' => 'Normal',
                            '1' => 'Subcontratação',
                            '2' => 'Redespacho',
                            '3' => 'Redespacho Intermediário',
                            '4' => 'Serviço Multimodal'
                ])
                ?>
            </td>
            <td><?= $form->field($model, 'ide_mod')->textInput(['value' => $model->isNewRecord ? '57' : $model->ide_mod, 'maxlength' => true]) ?></td>
            <td><?= $form->field($model, 'ide_serie')->textInput(['value' => $model->isNewRecord ? '001' : $model->ide_serie, 'maxlength' => true]) ?></td>
        </tr>
    </table>

    <table class="table table-hover">
        <tr>
            <td>Envolvidos</td>
        </tr>
    </table>
    <table class="table table-hover">
        <tr>
            <td width="20%">
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
            </td>
            <td><?= $form->field($model, 'remetente')->textInput(['maxlength' => true, 'readonly' => true]) ?></td>
            <td width="20%">
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
            </td>
            <td><?= $form->field($model, 'destinatario')->textInput(['maxlength' => true, 'readonly' => true]) ?></td>
        </tr>
    </table>

    <table class="table table-hover">
        <tr>
            <td width="20%">
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
            </td>
            <td><?= $form->field($model, 'expedidor')->textInput(['maxlength' => true, 'readonly' => true]) ?></td>
            <td width="20%">
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
            </td>
            <td><?= $form->field($model, 'recebedor')->textInput(['maxlength' => true, 'readonly' => true]) ?></td>
        </tr>
    </table>

    <table class="table table-hover">
        <tr>
            <td>
                <?=
                $form->field($model, 'toma')->dropDownList(
                        [
                    '0' => 'Remetente',
                    '3' => 'Destinatário',
                    '1' => 'Expedidor',
                    '2' => 'Recebedor',
                    '4' => 'Outros',
                        ], [
                    'prompt' => '-- Selecione --'
                ])
                ?>
            </td>
            <td>
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
            </td>
            <td>
<?= $form->field($model, 'tomador')->textInput(['maxlength' => true, 'readonly' => true]) ?>
            </td>
        </tr>
    </table>

    <table class="table table-hover">
        <tr>
            <td>
                <div class="form-group field-cte-origem required">
                    <label class="control-label" for="cte-origem">Origem</label>
<?= Html::dropDownList('cte-origem', null, [], ['id' => 'cte-origem', 'class' => 'form-control', 'prompt' => '-- Selecione --']); ?>
                </div>
            </td>
            <td>
                <div class="form-group field-cte-destino required">
                    <label class="control-label" for="cte-destino">Destino</label>
<?= Html::dropDownList('cte-destino', null, [], ['id' => 'cte-destino', 'class' => 'form-control', 'prompt' => '-- Selecione --']); ?>
                    <div class="help-block"></div>
                </div>
            </td>
        </tr>
    </table>

    <div class="hide">
        <table class="table table-hover">
            <tr>
                <td><?= $form->field($model, 'ide_cMunIni')->textInput() ?></td>
                <td><?= $form->field($model, 'ide_xMunIni')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'ide_UFIni')->textInput(['maxlength' => true]) ?></td>
            </tr>
        </table>

        <table class="table table-hover">
            <tr>
                <td><?= $form->field($model, 'ide_cMunFim')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'ide_xMunFim')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'ide_UFFim')->textInput(['maxlength' => true]) ?></td>
            </tr>
        </table>

        <table class="table table-hover">
            <tr>
                <td><?= $form->field($model, 'ide_natOp')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'ide_dhEmi')->textInput(['value' => $model->isNewRecord ? date('Y-m-d\TH:i:s') : $model->ide_dhEmi]) ?></td>
                <td><?= $form->field($model, 'emitente')->textInput(['value' => Yii::$app->user->identity['cnpj'], 'maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'icms')->textInput(['maxlength' => true]) ?></td>
            </tr>
        </table>

        <table class="table table-hover">
            <tr>
                <td><?= $form->field($model, 'ide_cMunEnv')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'ide_xMunEnv')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'ide_UFEnv')->textInput(['maxlength' => true]) ?></td>
            </tr>
        </table>

        <table class="table table-hover">
            <tr>
                <td><?= $form->field($model, 'infCarga')->textInput() ?></td>
            </tr>
        </table>

        <table class="table table-hover">
            <tr>
                <td><?=
                    $form->field($model, 'ide_procEmi')->dropDownList(
                            [
                                '0' => 'Aplicativo do Contribuinte',
                                '1' => 'Fisco (Avulsa)',
                                '2' => 'Contribuinte (Avulsa)',
                                '3' => 'Aplicativo do Fisco'
                    ])
                    ?></td>
                <td><?= $form->field($model, 'ide_verProc')->textInput(['value' => '2.0']) ?></td>
            </tr>
        </table>

    </div>

    <table class="table table-hover">
        <tr>
            <td><?= $form->field($model, 'ide_CFOP')->dropDownList([], ['prompt' => '-- Selecione --']) ?></td>
        </tr>
    </table>

    <table class="table table-hover">
        <tr>
            <td><?=
                $form->field($model, 'ide_forPag')->dropDownList([
                    '2' => 'Faturado / Outros', '0' => 'Pago', '1' => 'A pagar'
                ])
                ?></td>
            <td>
                <?=
                $form->field($model, 'ide_retira')->dropDownList(
                        [
                            '1' => 'Não',
                            '0' => 'Sim',
                ])
                ?>
            </td>
            <td>
<?= $form->field($model, 'ide_xDetRetira')->textInput(['maxlength' => true]) ?>
            </td></tr>
    </table>

    <table class="table table-hover">
        <tr>
            <td width="100%">
                <div class="form-group">
                    <label class="control-label" for="cte-documentos">Tipo de Documento</label>
                    <?=
                    Html::dropDownList('cte-documentos', null, [
                        'NFE' => 'Nota Fiscal Eletrônica (NF-e)',
                        'NF' => 'Nota Fiscal (NF)',
                        'OUTROS' => 'Outros (Declaração, Dutoviário, NFC-e, etc)'
                            ], ['id' => 'cte-documentos', 'class' => 'form-control', 'prompt' => '-- Selecione --']);
                    ?>
                    <p class="help-block help-block-error"></p>
                </div>
            </td>
        </tr>
    </table>

    <?php
    if (!$model->isNewRecord) {

        $notasnumero = explode('|', $model->notasnumero);
        $notasvalor = explode('|', $model->notasvalor);
        $notasaltura = explode('|', $model->notasaltura);
        $notaslargura = explode('|', $model->notaslargura);
        $notascomprimento = explode('|', $model->notascomprimento);
        $notaspeso = explode('|', $model->notaspeso);
        $notasvolumes = explode('|', $model->notasvolumes);
    } else {

        $notasnumero = ['', ''];
        $notasaltura = ['', ''];
        $notaslargura = ['', ''];
        $notascomprimento = ['', ''];
    }

    for ($i = 1; $i <= count($notasnumero) - 1; $i++) {

        $j = $i - 1;
        ?>

        <div class="linhas 0">
            <table class="table table-hover">
                <tr>
                    <td width="33%">
                        <div class="form-group">
                            <label class="control-label" for="cte-notasnumero">Nota</label>
    <?= Html::input('text', 'notasnumerox[]', (($model->isNewRecord) ? '' : $notasnumero[$i]), ['class' => 'form-control', 'id' => 'cte-notasnumerox' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="10%">
                        <div class="form-group">
                            <label class="control-label" for="cte-notasvalor">Valor</label>
    <?= Html::input('text', 'notasvalorx[]', (($model->isNewRecord) ? '' : $notasvalor[$i]), ['class' => 'form-control dinheiro', 'id' => 'cte-notasvalorx' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="10%">
                        <div class="form-group">
                            <label class="control-label" for="cte-notasaltura">Altura</label>
    <?= Html::input('text', 'notasalturax[]', (($model->isNewRecord) ? '' : $notasaltura[$i]), ['class' => 'form-control dimensao', 'id' => 'cte-notasalturax' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="10%">
                        <div class="form-group">
                            <label class="control-label" for="cte-notaslargura">Largura</label>
    <?= Html::input('text', 'notaslargurax[]', (($model->isNewRecord) ? '' : $notaslargura[$i]), ['class' => 'form-control dimensao', 'id' => 'cte-notaslargurax' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="10%">
                        <div class="form-group">
                            <label class="control-label" for="cte-notascomprimento">Comp.</label>
    <?= Html::input('text', 'notascomprimentox[]', (($model->isNewRecord) ? '' : $notascomprimento[$i]), ['class' => 'form-control dimensao', 'id' => 'cte-notascomprimentox' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="9%">
                        <div class="form-group">
                            <label class="control-label" for="cte-notaspeso">Peso</label>
    <?= Html::input('text', 'notaspesox[]', (($model->isNewRecord) ? '' : $notaspeso[$i]), ['class' => 'form-control peso', 'id' => 'cte-notaspesox' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="7%">
                        <div class="form-group">
                            <label class="control-label" for="cte-notasvolumes">Vol.</label>
    <?= Html::input('text', 'notasvolumesx[]', (($model->isNewRecord) ? '' : $notasvolumes[$i]), ['class' => 'form-control', 'id' => 'cte-notasvolumesx' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="11%">
                        <div class="form-group">
                            <label class="control-label" for="cte-notasdprev">Entrega</label>
    <?= Html::input('text', 'notasdprevx[]', (($model->isNewRecord) ? '' : $notasdprev[$i]), ['class' => 'form-control data', 'id' => 'cte-notasdprevx' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="2%">
                        <span class="remover" id="0"><i class="fa fa-remove"></i></span>
                    </td>
                </tr>
            </table>
            <div class="nf_notasfiscais">
                <table class="table table-hover">
                    <tr>
                        <td width="10%">
                            <div class="form-group">
                                <label class="control-label" for="cte-nf_nroma">Nº Romaneio</label>
    <?= Html::input('text', 'nf_nromax[]', (($model->isNewRecord) ? '' : $nroma[$i]), ['disabled' => true, 'class' => 'form-control', 'id' => 'cte-nf_nromax' . $j]); ?>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </td>
                        <td width="10%">
                            <div class="form-group">
                                <label class="control-label" for="cte-nf_nped">Nº Pedido</label>
    <?= Html::input('text', 'nf_npedx[]', (($model->isNewRecord) ? '' : $nped[$i]), ['disabled' => true, 'class' => 'form-control', 'id' => 'cte-nf_npedx' . $j]); ?>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </td>
                        <td width="15%">
                            <div class="form-group">
                                <label class="control-label" for="cte-nf_mod">Modelo</label>
                                <?=
                                Html::dropDownList('nf_modx[]', null, [
                                    '01' => "01 ou Avulsa",
                                    '04' => "Produtor"
                                        ], ['id' => 'cte-nf_modx' . $j, 'class' => 'form-control', 'disabled' => true, 'prompt' => '-- Selecione --']);
                                ?>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </td>
                        <td width="10%">
                            <div class="form-group">
                                <label class="control-label" for="cte-nf_serie">Serie</label>
    <?= Html::input('text', 'nf_seriex[]', (($model->isNewRecord) ? '' : $serie[$i]), ['disabled' => true, 'class' => 'form-control', 'id' => 'cte-nf_seriex' . $j]); ?>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </td>
                        <td width="10%">
                            <div class="form-group">
                                <label class="control-label" for="cte-nf_demi">Emissão</label>
    <?= Html::input('text', 'nf_demix[]', (($model->isNewRecord) ? '' : $demi[$i]), ['disabled' => true, 'class' => 'form-control data', 'id' => 'cte-nf_demix' . $j]); ?>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </td>
                        <td width="10%">
                            <div class="form-group">
                                <label class="control-label" for="cte-nf_ncfop">CFOP</label>
    <?= Html::input('text', 'nf_ncfopx[]', (($model->isNewRecord) ? '' : $ncfop[$i]), ['disabled' => true, 'class' => 'form-control', 'id' => 'cte-nf_ncfopx' . $j]); ?>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </td>
                        <td width="10%">
                            <div class="form-group">
                                <label class="control-label" for="cte-nf_pin">PIN</label>
    <?= Html::input('text', 'nf_pinx[]', (($model->isNewRecord) ? '' : $pin[$i]), ['disabled' => true, 'class' => 'form-control', 'id' => 'cte-nf_pinx' . $j]); ?>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="nf_notasoutros">
                <table class="table table-hover">
                    <tr>
                        <td width="35%">
                            <div class="form-group">
                                <label class="control-label" for="cte-nf_tpdoc">Tipo Doc.</label>
                                <?=
                                Html::dropDownList('nf_tpdocx', null, [
                                    '00' => 'Declaração',
                                    '10' => 'Dutoviário',
                                    '59' => 'CF-e SAT',
                                    '65' => 'NFC-e',
                                    '99' => 'Outros'
                                        ], ['id' => 'cte-nf_tpdocx' . $j, 'class' => 'form-control', 'disabled' => true, 'prompt' => '-- Selecione --']);
                                ?>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </td>
                        <td width="40%">
                            <div class="form-group">
                                <label class="control-label" for="cte-nf_descoutros">Descrição / Chave</label>
    <?= Html::input('text', 'nf_descoutrosx[]', (($model->isNewRecord) ? '' : $descoutros[$i]), ['disabled' => true, 'class' => 'form-control', 'id' => 'cte-nf_descoutrosx' . $j]); ?>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </td>
                        <td width="25%">
                            <div class="form-group">
                                <label class="control-label" for="cte-nf_outrosdemi">Emissão</label>
    <?= Html::input('text', 'nf_outrosdemix[]', (($model->isNewRecord) ? '' : $outrosdemi[$i]), ['disabled' => true, 'class' => 'form-control data', 'id' => 'cte-nf_outrosdemix' . $j]); ?>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <?php
    }
    ?>

    <span class="label label-success adicionarCampo" id="linhas">Adicionar outra nota</span>

    <br/><br/>

    <table class="table table-hover">
        <tr>
            <td><?= $form->field($model, 'tabela')->dropDownList(($model->isNewRecord ? [] : $tabela), ['id' => 'tabelaAjax', 'prompt' => '-- Selecione --']) ?></td>
            <td><?= $form->field($model, 'taxaextra')->textInput(['maxlength' => true, 'class' => 'form-control dinheiro']) ?></td>
            <td><?= $form->field($model, 'desconto')->textInput(['maxlength' => true, 'class' => 'form-control dinheiro']) ?></td>
        </tr>
    </table>

    <div id="retornoCalculos">
        <table class="table table-hover">
            <tr>
                <td colspan='5'><span class="text-green text-bold">Cálculo do Frete</span></td>
            </tr>
            <tr class='retornoFinal'>

            </tr>
        </table>
    </div>

    <table class="table table-hover">
        <tr>
            <td><?= $form->field($model, 'comp_xNome')->textInput(['maxlength' => true]) ?></td>
            <td><?= $form->field($model, 'comp_vComp')->textInput() ?></td>
            <td><?= $form->field($model, 'vPrest_vTPrest')->textInput() ?></td>
            <td><?= $form->field($model, 'vPrest_vRec')->textInput() ?></td>
        </tr>
    </table>

    <table class="table table-hover">
        <tr>
            <td>
                <div class="form-group field-tributo-icms required">
                    <label class="control-label" for="tributo-icms">Classificação Tributária</label>
                    <?=
                    Html::dropDownList('tributo-icms', null, [
                        '00' => 'Tributação Normal do ICMS',
                        '20' => 'Base de Cálculo Reduzida do ICMS',
                        '40' => 'Isenção de ICMS',
                        '41' => 'ICMS Não Tributado',
                        '51' => 'ICMS Não Diferido',
                        '60' => 'ICMS por Substituição Tributária',
                        '90SN' => 'ICMS Simples Nacional',
                        '90' => 'Outros',
                            ], ['id' => 'tributo-icms', 'class' => 'form-control', 'prompt' => '-- Selecione --']);
                    ?>
                    <div class="help-block"></div>
                </div>
            </td>
        </tr>
    </table>

    <div id="icms">
        <table class="table table-hover">
            <tr>
                <td>
                    <div class="form-group field-icms-cst required">
                        <label class="control-label" for="icms-cst">Classificação Tributária</label>
<?= Html::input('text', 'icms-cst', null, ['id' => 'icms-cst', 'class' => 'form-control', 'readonly' => true]); ?>
                        <div class="help-block"></div>
                    </div>
                </td>
                <td>
                    <div class="form-group field-icms-vbc required">
                        <label class="control-label" for="icms-vbc">Base de Cálculo</label>
<?= Html::input('text', 'icms-vbc', null, ['id' => 'icms-vbc', 'class' => 'form-control', 'readonly' => true]); ?>
                        <div class="help-block"></div>
                    </div>
                </td>
                <td>
                    <div class="form-group field-icms-picms required">
                        <label class="control-label" for="icms-picms">Alíquota do ICMS</label>
<?= Html::input('text', 'icms-picms', null, ['id' => 'icms-picms', 'class' => 'form-control', 'readonly' => true]); ?>
                        <div class="help-block"></div>
                    </div>
                </td>
                <td>
                    <div class="form-group field-icms-vicms required">
                        <label class="control-label" for="icms-vicms">Valor do ICMS</label>
<?= Html::input('text', 'icms-vicms', null, ['id' => 'icms-vicms', 'class' => 'form-control', 'readonly' => true]); ?>
                        <div class="help-block"></div>
                    </div>
                </td>
                <td>
                    <div class="form-group field-icms-predbc required">
                        <label class="control-label" for="icms-predbc">Percentual da Redução da BC</label>
<?= Html::input('text', 'icms-predbc', null, ['id' => 'icms-predbc', 'class' => 'form-control', 'readonly' => true]); ?>
                        <div class="help-block"></div>
                    </div>
                </td>
            </tr>
        </table>

        <table class="table table-hover">
            <tr>
                <td>
                    <div class="form-group field-icms-vbcstret required">
                        <label class="control-label" for="icms-vbcstret">R$ da BC ST Retido</label>
<?= Html::input('text', 'icms-vbcstret', null, ['id' => 'icms-vbcstret', 'class' => 'form-control', 'readonly' => true]); ?>
                        <div class="help-block"></div>
                    </div>
                </td>
                <td>
                    <div class="form-group field-icms-vicmsstret required">
                        <label class="control-label" for="icms-vicmsstret">R$ do ST Retido</label>
<?= Html::input('text', 'icms-vicmsstret', null, ['id' => 'icms-vicmsstret', 'class' => 'form-control', 'readonly' => true]); ?>
                        <div class="help-block"></div>
                    </div>
                </td>
                <td>
                    <div class="form-group field-icms-picmsstret required">
                        <label class="control-label" for="icms-picmsstret">Alíquota do ICMS Ret.</label>
<?= Html::input('text', 'icms-picmsstret', null, ['id' => 'icms-picmsstret', 'class' => 'form-control', 'readonly' => true]); ?>
                        <div class="help-block"></div>
                    </div>
                </td>
                <td>
                    <div class="form-group field-icms-vcred required">
                        <label class="control-label" for="icms-vcred">R$ do Crédito outorgado</label>
<?= Html::input('text', 'icms-vcred', null, ['id' => 'icms-vcred', 'class' => 'form-control', 'readonly' => true]); ?>
                        <div class="help-block"></div>
                    </div>
                </td>
                <td>
                    <div class="form-group field-icms-vtottrib required">
                        <label class="control-label" for="icms-vtottrib">Valor Tributos</label>
<?= Html::input('text', 'icms-vtottrib', null, ['id' => 'icms-vtottrib', 'class' => 'form-control', 'readonly' => true]); ?>
                        <div class="help-block"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table class="table table-hover">
        <tr>
            <td>
                <div class="form-group field-carga-vcarga required">
                    <label class="control-label" for="carga-vcarga">Valor Total da Carga</label>
<?= Html::input('text', 'carga-vcarga', null, ['id' => 'carga-vcarga', 'class' => 'form-control', 'readonly' => true]); ?>
                    <div class="help-block"></div>
                </div>
            </td>
            <td>
                <div class="form-group field-carga-prodpred required">
                    <label class="control-label" for="carga-prodpred">Prod. Predominante</label>
<?= Html::input('text', 'carga-prodpred', null, ['id' => 'carga-prodpred', 'class' => 'form-control', 'readonly' => false]); ?>
                    <div class="help-block"></div>
                </div>
            </td>
            <td>
                <div class="form-group field-carga-xoutcat required">
                    <label class="control-label" for="carga-xoutcat">Outras Características</label>
<?= Html::input('text', 'carga-xoutcat', null, ['id' => 'carga-xoutcat', 'class' => 'form-control', 'readonly' => false]); ?>
                    <div class="help-block"></div>
                </div>
            </td>
        </tr>
    </table>

    <!--
       Fazer com os proximos tres inputs o mesmo que foi feito com os dados das notas da minuta!!
    -->

    <?= $form->field($model, 'infQ_cUnid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'infQ_tpMed')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'infQ_qCarga')->textInput() ?>

    <?= $form->field($model, 'infNFe')->textInput() ?>

    <?= $form->field($model, 'infNF')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seguro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'infModal_versaoModal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rodo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'veiculo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'motorista')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pathXML')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pathPDF')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entrega_data')->textInput() ?>

    <?= $form->field($model, 'entrega_hora')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entrega_nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entrega_doc')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
<?= Html::button(Yii::t('app', 'Testar'), ['class' => 'btn btn-success', 'id' => 'btn-testar']) ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
