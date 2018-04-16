<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\cte\models\CteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$od = $model->ufcarga . ' => ' . $model->ufdescarga;

$this->title                   = Yii::t('app', 'Encerrar MDF-e (' . $od . ')');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mdfe-encerrar">
    <?php
    $form                          = ActiveForm::begin([
            'id' => 'encerrar-form'
    ]);
    ?>

    <div class="col-sm-6">
        Chave: <?=
        Html::input('text', 'chave', $model->chave,
            ['class' => 'form-control', 'readonly' => true]);
        ?>
    </div>

    <div class="col-sm-6">
        Protocolo: <?php
        echo Html::input('text', 'protocolo', $model->mdfeProtocolos[0]->nprot,
            ['class' => 'form-control', 'readonly' => true]);
        ?>
    </div>

    <div class="col-sm-2">
        UF: <?php
        echo Html::dropDownList('cUF', NULL, $ufs,
            [
            'class' => 'form-control',
            'prompt' => '-- Selecione --'
        ]);
        ?>
    </div>

    <div class="col-sm-5">
        <div class="form-group">
            <label class="control-label" for="tabela-nome">Pesquisa Município</label>
            <?=
            AutoComplete::widget([
                'id' => "xmun-nome",
                'name' => "xmun-nome",
                'clientOptions' => [
                    'source' => $municipios,
                    'autoFill' => true,
                    'minLength' => 2,
                    'select' => new JsExpression("function( event, ui ) {
                                    $('#cmun').val(ui.item.id); // Campo real do cMun
                                    $('#cmun').focus();
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

    <div class="col-sm-3">
        Município: <?php
        echo Html::input('text', 'cMun', '',
            ['class' => 'form-control', 'id' => 'cmun']);
        ?>
    </div>

    <div class="col-sm-2">
        <br /><?= Html::submitButton('Encerrar MDF-e',
            ['class' => 'btn btn-success'])
        ?>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <br><br>
            <p>
                <?php
                if (!empty($retorno)) {
                    if ($retorno['cStat'] != '135') {
                        echo $retorno['cStat'].' - '.$retorno['xMotivo'];
                    } else {
                        echo 'Manifesto encerrado com sucesso.';
                    }
                }
                ?>
            </p>
        </div>
    </div>

<?php ActiveForm::end(); ?>

</div>
