<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\veiculos\models\VeiculosTpcar;
use backend\modules\veiculos\models\VeiculosTpveic;
use backend\modules\veiculos\models\VeiculosTprod;
use yii\helpers\ArrayHelper;

$find_tprod = VeiculosTprod::find()
//    ->select('id', 'descricao')
    ->asArray()
    ->all();

$tprod = ArrayHelper::map($find_tprod, 'id', 'descricao');

$find_tpcar = VeiculosTpcar::find()
    //->select('id', 'descricao')
    ->asArray()
    ->all();

$tpcar = ArrayHelper::map($find_tpcar, 'id', 'descricao');

$find_tpveic = VeiculosTpveic::find()
//    ->select('id', 'descricao')
    ->asArray()
    ->all();

$tpveic = ArrayHelper::map($find_tpveic, 'id', 'descricao');
//echo '<pre>';
//var_dump($find_tpveic);
//var_dump($tpveic);


/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\Veiculos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="veiculos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-3"><?= $form->field($model, 'placa')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'marca')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'modelo')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'cint')->textInput(['maxlength' => true]) ?></div>
    </div>

    <div class="row">
        <div class="col-sm-3"><?= $form->field($model, 'renavam')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'tara')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'capkg')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'capm3')->textInput(['maxlength' => true]) ?></div>
    </div>

    <div class="row">
        <div class="col-sm-3"><?= $form->field($model, 'tpveic_id')->dropDownList($tpveic,['prompt' => '-- Selecione --']) ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'tprod_id')->dropDownList($tprod,['prompt' => '-- Selecione --']) ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'tpcar_id')->dropDownList($tpcar,['prompt' => '-- Selecione --']) ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'uf')->textInput(['maxlength' => true]) ?></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
