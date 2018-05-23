<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use backend\assets\CteAsset;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Url;

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

    <div class="panel panel-default">

        <!-- Dados Gerais -->
        <div class="panel-heading">
            <i class="fa fa-filter"></i> Filtros para download
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label" for="recebedor-nome">Data Inicial</label>
                        <?= Html::input('text', 'di', null, ['class' => 'form-control data']); ?>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label" for="recebedor-nome">Data Final</label>
                        <?= Html::input('text', 'df', null, ['class' => 'form-control data']); ?>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label" for="recebedor-nome">Status</label>
                        <?= Html::dropDownList('status', null, [
                            'AUTORIZADO' => 'AUTORIZADO'
                        ], ['class' => 'form-control']); ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="recebedor-nome">Tomador pesq.</label>
                        <?=
                        AutoComplete::widget([
                            'name' => 'tomador-nome',
                            'id' => 'tomador-nome',
                            'clientOptions' => [
                                'source' => Url::to(['/ajax/retorna-clientes']),
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
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label" for="tomador-nome">Tomador</label>
                        <?=
                        Html::input('text', 'tomador', null, ['id' => 'cte-tomador', 'class' => 'form-control']);
                        ?>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Baixar'),
        ['class' => 'btn btn-primary']);
    ?>
    <?= $msg; ?>
</div>

<?php ActiveForm::end(); ?>

</div>
