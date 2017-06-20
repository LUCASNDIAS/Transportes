<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model backend\modules\mdfe\models\Mdfe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mdfe-form">

    <?php $form = ActiveForm::begin([
        'id' => 'dynamic-form'
    ]); ?>

    <!-- Dados internos -->
    <div class="row hiden">
        <div class="col-sm-2"><?= $form->field($model, 'cridt')->textInput(['readonly' => true,
        'value' => ($model->isNewRecord) ? date('Y-m-d') : $model['cridt']]); ?></div>
        <div class="col-sm-2"><?= $form->field($model, 'criusu')->textInput(['maxlength' => true,
        'readonly' => true, 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['apelido']
                : $model['criusu']]); ?></div>
        <div class="col-sm-2"><?= $form->field($model, 'dono')->textInput(['maxlength' => true,
        'readonly' => true, 'id' => 'dono', 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['cnpj']
                : $model['dono']]); ?></div>
        <div class="col-sm-1"><?= $form->field($model, 'status')->textInput(['maxlength' => true,
        'readonly' => true, 'value' => ($model->isNewRecord) ? '1' : $model['status']]); ?></div>
        <div class="col-sm-5"><?= $form->field($model, 'chave')->textInput(['maxlength' => true]) ?></div>
    </div>

    <div class="panel panel-default">

        <!-- Dados Gerais -->
        <div class="panel-heading">
            <i class="fa fa-id-card"></i> Dados gerais
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-2"><?= $form->field($model, 'modelo')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-2"><?= $form->field($model, 'serie')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-2"><?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'dtemissao')->textInput() ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'dtinicio')->textInput() ?></div>
            </div>
            <div class="row">
                <div class="col-sm-2"><?= $form->field($model, 'uf')->dropDownList([
                    'MG' => 'MG'
                ],['prompt'=>'-- Selecione --']) ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'tipoemitente')->dropDownList([
                    '1' => 'Prestador de serviço transporte',
                    '2' => 'Transportador de carga própria'
                ],['prompt'=>'-- Selecione --']) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'modalidade')->dropDownList([
                    '1' => 'Rodoviário',
                    '2' => 'Aéreo',
                    '3' => 'Aquaviário',
                    '4' => 'Ferroviário'
                ],['prompt'=>'-- Selecione --']) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'formaemissao')->dropDownList([
                    '1' => 'Normal',
                    '2' => 'Contingência'
                ],['prompt'=>'-- Selecione --']) ?></div>
            </div>
            <div class="row">
                <div class="col-sm-6"><?= $form->field($model, 'ufcarga')->dropDownList([
                    'MG' => 'MG'
                ],['prompt'=>'-- Selecione --']) ?></div>
                <div class="col-sm-6"><?= $form->field($model, 'ufdescarga')->dropDownList([
                    'MG' => 'MG'
                ],['prompt'=>'-- Selecione --']) ?></div>
            </div>
        </div>
    </div>

    <!-- Rodoviário -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-id-card"></i> Rodoviário
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4"><?= $form->field($model, 'rntrc')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'ciot')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'placa')->textInput(['maxlength' => true]) ?></div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">

        <!-- Totalizadores -->
        <div class="panel-heading">
            <i class="fa fa-id-card"></i> Totalizadores
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4"><?= $form->field($model, 'qtdecte')->textInput() ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'qtdenfe')->textInput() ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'qtdenf')->textInput() ?></div>
            </div>
            <div class="row">
                <div class="col-sm-4"><?= $form->field($model, 'valormercadoria')->textInput() ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'unidademedida')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-4"><?= $form->field($model, 'pesomercadoria')->textInput() ?></div>
            </div>
            
        </div>

    </div>

    <div class="panel panel-default">

        <!-- Informações adicionais -->
        <div class="panel-heading">
            <i class="fa fa-id-card"></i> Informações adicionais
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6"><?= $form->field($model, 'inffisco')->textarea(['maxlength' => true]) ?></div>
                <div class="col-sm-6"><?= $form->field($model, 'infcontribuinte')->textarea(['maxlength' => true]) ?></div>
            </div>
        </div>

    </div>

    <?php
DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items', // required: css class selector
    'widgetItem' => '.item', // required: css class
    'limit' => 25, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
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
            <i class="fa fa-envelope"></i> Contatos
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
    $form->field($modelPercurso, "[{$index}]uf")->dropDownList([
        'MG' => 'Minas Gerais',
        'SP' => 'São Paulo'
    ],[
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

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'),
            ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
