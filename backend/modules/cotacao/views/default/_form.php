<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\CotacaoAsset;
use backend\modules\clientes\models\Clientes;
use yii\web\JsExpression;
use yii\jui\AutoComplete;
use backend\commands\Basicos;
use yii\helpers\Url;

//use Yii;


/* @var $this yii\web\View */
/* @var $model backend\models\Minutas */
/* @var $form yii\widgets\ActiveForm */

// Variável Temporária para modelo de tabelas do cliente!
//$tabela = array(
//    '1' => 'TABELA 01',
//    '2' => 'TABELA 02'
//);
// Asset
CotacaoAsset::register($this);

// Funções Basicas
$basico = new Basicos();

// Datas
if (!$model->isNewRecord) {
    $model->coletadata = ($model->coletadata == '0000-00-00') ? '' : $basico->formataData('ver', $model->coletadata);
    $model->entregadata = ($model->entregadata == '0000-00-00') ? '' : $basico->formataData('ver', $model->entregadata);
}

//Busca de Clientes ------ PASSAR PARA O MODEL E TROCAR SOURCE -------
$data = Clientes::find()
        ->select([new \yii\db\Expression("nome as value, CONCAT( `nome`,' | ',`cnpj`) as label, cnpj, endcid")])
        ->where(['dono' => Yii::$app->user->identity['cnpj']])
        ->asArray()
        ->all();

//var_dump($formulario);
?>



<div class="cotacao-form">

    <?php $form = ActiveForm::begin(['id' => 'cotacao-form']); ?>


    <table class="table table-hover hide">
        <tr>
            <td>Controle Interno</td>
        </tr>
    </table>
    <table class="table table-hover hide">
        <tr>
            <td><?= $form->field($model, 'cridt')->textInput(['readonly' => true, 'value' => ($model->isNewRecord) ? date('Y-m-d') : $model['cridt']]); ?></td>
            <td><?= $form->field($model, 'criusu')->textInput(['maxlength' => true, 'readonly' => true, 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['apelido'] : $model['criusu']]); ?></td>
            <td><?= $form->field($model, 'dono')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'dono', 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['cnpj'] : $model['dono']]); ?></td>
        </tr>
    </table>
    <table class="table table-hover">
        <tr>
            <td>Envolvidos</td>
            <td><?= Html::a('Cliente não cadastrado? Cadastre aqui.', Url::to(['/clientes/default/create']), ['target' => '_blank']) ?></td>
            <td><span class="rm-cons">Remover consignatário</span></td>
        </tr>
    </table>
    <table class="table table-hover">
        <tr>
            <td width="20%">
                <div class="form-group">
                    <label class="control-label" for="remetente-nome">Rem. pesquisa</label>
                    <?=
                    AutoComplete::widget([
                        'name' => 'remetente-nome',
                        'id' => 'remetente-nome',
                        'clientOptions' => [
//                            'source' => $data,
                            'source' => Url::to(['/ajax/retorna-clientes']),
                            'autoFill' => true,
                            'minLength' => 4,
                            'select' => new JsExpression("function( event, ui ) {
									     $('#cotacao-remetente').val(ui.item.cnpj); // Campo real do remetente
										 $('#cotacao-remetente').focus();
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
                    <label class="control-label" for="destinatario-nome">Dest. pesquisa</label>
                    <?=
                    AutoComplete::widget([
                        'name' => 'destinatario-nome',
                        'id' => 'destinatario-nome',
                        'clientOptions' => [
                            'source' => Url::to(['/ajax/retorna-clientes']),
                            'autoFill' => true,
                            'minLength' => 4,
                            'select' => new JsExpression("function( event, ui ) {
									     $('#cotacao-destinatario').val(ui.item.cnpj); // Campo real do remetente
										 $('#cotacao-destinatario').focus();
										 $('#consignatario-nome').focus();
										 $('#cotacao-entregalocal').val(ui.item.endcid);
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
            <td width="20%">
                <div class="form-group">
                    <label class="control-label" for="consignatario-nome">Cons. pesquisa</label>
                    <?=
                    AutoComplete::widget([
                        'name' => 'consignatario-nome',
                        'id' => 'consignatario-nome',
                        'clientOptions' => [
                            'source' => Url::to(['/ajax/retorna-clientes']),
                            'autoFill' => true,
                            'minLength' => 4,
                            'select' => new JsExpression("function( event, ui ) {
									     $('#cotacao-consignatario').val(ui.item.cnpj); // Campo real do remetente
										 $('#cotacao-consignatario').focus();
										 $('#cotacao-pagadorenvolvido').focus();
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
            <td><?= $form->field($model, 'consignatario')->textInput(['maxlength' => true, 'readonly' => true]) ?></td>
        </tr>
    </table>
    <table class="table table-hover">
        <tr>
            <td>Dados do Frete</td>
        </tr>
    </table>
    <table class="table table-hover">
        <tr>
            <td>
                <?=
                $form->field($model, 'tipofrete')->dropDownList(
                        [
                    'RODOVIARIO' => 'Rodoviário',
                    'AEREO' => 'Aéreo',
                    'MARITIMO' => 'Marítimo',
                        ], ['options' => [
                        $model->tipofrete => ['Selected' => ($model->isNewRecord) ? '' : 'selected'],
                        'RODOVIARIO' => ['Selected' => ($model->isNewRecord) ? 'selected' : ''],
                    ],
                    'prompt' => ' -- Selecione --']
                )
                ?>			    
            </td>
            <td>
                <?=
                $form->field($model, 'pagadorenvolvido')->dropDownList(
                        [
                    'REMETENTE' => 'Remetente',
                    'DESTINATARIO' => 'Destinatário',
                    'CONSIGNATARIO' => 'Consignatário',
                        ], ['options' => [$model->pagadorenvolvido => ['Selected' => ($model->isNewRecord) ? '' : 'selected']],
                    'prompt' => ' -- Selecione --']
                )
                ?>
            </td>
            <td><?= $form->field($model, 'formapagamento')->textInput(['maxlength' => true, 'value' => ($model->isNewRecord) ? 'FATURADO' : $model->formapagamento]) ?></td>
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
                    <td width="20%">
                        <div class="form-group">
                            <label class="control-label" for="cotacao-notasnumero">Nota</label>
                            <?= Html::input('text', 'notasnumerox[]', (($model->isNewRecord) ? '' : $notasnumero[$i]), ['class' => 'form-control', 'id' => 'cotacao-notasnumerox' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="15%">
                        <div class="form-group">
                            <label class="control-label" for="cotacao-notasvalor">Valor</label>
                            <?= Html::input('text', 'notasvalorx[]', (($model->isNewRecord) ? '' : $notasvalor[$i]), ['class' => 'form-control dinheiro', 'id' => 'cotacao-notasvalorx' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="15%">
                        <div class="form-group">
                            <label class="control-label" for="cotacao-notasaltura">Altura</label>
                            <?= Html::input('text', 'notasalturax[]', (($model->isNewRecord) ? '' : $notasaltura[$i]), ['class' => 'form-control dimensao', 'id' => 'cotacao-notasalturax' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="15%">
                        <div class="form-group">
                            <label class="control-label" for="cotacao-notaslargura">Largura</label>
                            <?= Html::input('text', 'notaslargurax[]', (($model->isNewRecord) ? '' : $notaslargura[$i]), ['class' => 'form-control dimensao', 'id' => 'cotacao-notaslargurax' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="15%">
                        <div class="form-group">
                            <label class="control-label" for="cotacao-notascomprimento">Comprimento</label>
                            <?= Html::input('text', 'notascomprimentox[]', (($model->isNewRecord) ? '' : $notascomprimento[$i]), ['class' => 'form-control dimensao', 'id' => 'cotacao-notascomprimentox' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="9%">
                        <div class="form-group">
                            <label class="control-label" for="cotacao-notaspeso">Peso</label>
                            <?= Html::input('text', 'notaspesox[]', (($model->isNewRecord) ? '' : $notaspeso[$i]), ['class' => 'form-control peso', 'id' => 'cotacao-notaspesox' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="9%">
                        <div class="form-group">
                            <label class="control-label" for="cotacao-notasvolumes">Volumes</label>
                            <?= Html::input('text', 'notasvolumesx[]', (($model->isNewRecord) ? '' : $notasvolumes[$i]), ['class' => 'form-control', 'id' => 'cotacao-notasvolumesx' . $j]); ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </td>
                    <td width="2%">
                        <span class="remover" id="0"><i class="fa fa-remove"></i></span>
                    </td>
                </tr>
            </table>
        </div>

        <?php
    }
    ?>

    <span class="label label-success adicionarCampo" id="linhas">Adicionar outra nota</span>
    <p>
    <table class="table table-hover">
        <tr>
            <td><?= $form->field($model, 'entregalocal')->textInput(['maxlength' => true]) ?></td>
            <td><?= $form->field($model, 'naturezacarga')->textInput(['maxlength' => true]) ?></td>
            <td><?= $form->field($model, 'pesoreal')->textInput(['maxlength' => true, 'class' => 'form-control peso']) ?></td>
            <td><?= $form->field($model, 'pesocubado')->textInput(['maxlength' => true, 'class' => 'form-control peso']) ?></td>
        </tr>
    </table>

    <table class="table table-hover">
        <tr>
            <td><?= $form->field($model, 'tabela')->dropDownList(($model->isNewRecord) ? [] : [$model->tabela => $model->tabela], ['id' => 'tabelaAjax', 'prompt' => '-- Selecione --']) ?></td>
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
            <td><?= $form->field($model, 'observacoes')->textInput(['maxlength' => true]) ?></td>
        </tr>
    </table>

    <table class="table table-hover">
        <tr>
            <td>Coleta</td>
        </tr>
    </table>
    <table class="table table-hover">
        <tr>
            <td><?= $form->field($model, 'coletadata')->textInput(['maxlength' => true, 'class' => 'form-control data']) ?></td>
            <td><?= $form->field($model, 'coletahora')->textInput(['maxlength' => true, 'class' => 'form-control hora']) ?></td>
            <td><?= $form->field($model, 'coletanome')->textInput(['maxlength' => true]) ?></td>
            <td><?= $form->field($model, 'coletaplaca')->textInput(['maxlength' => true, 'class' => 'form-control placa']) ?></td>
        </tr>
    </table>

    <table class="table table-hover">
        <tr>
            <td>Entrega</td>
        </tr>
    </table>
    <table class="table table-hover">
        <tr>
            <td><?= $form->field($model, 'entregadata')->textInput(['maxlength' => true, 'class' => 'form-control data']) ?></td>
            <td><?= $form->field($model, 'entregahora')->textInput(['maxlength' => true, 'class' => 'form-control hora']) ?></td>
            <td><?= $form->field($model, 'entreganome')->textInput(['maxlength' => true]) ?></td>
            <td><?= $form->field($model, 'entregadoc')->textInput(['maxlength' => true]) ?></td>
        </tr>
    </table>

    <div class="hide">
        <table class="table table-hover">
            <tr>
                <td>Notas - Campos Reais</td>
            </tr>
        </table>
        <table class="table table-hover">
            <tr>
                <td><?= $form->field($model, 'notasnumero')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'notasvalor')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'notasaltura')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'notaslargura')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'notascomprimento')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'notaspeso')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'notasvolumes')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'notasdimensoes')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'pagadorcnpj')->textInput(['maxlength' => true]) ?></td>
            </tr>
        </table>    
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>