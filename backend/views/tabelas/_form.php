<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\TabelasAsset;
use yii\helpers\ArrayHelper;
use backend\models\Tabelas;

/* @var $this yii\web\View */
/* @var $model backend\models\Tabelas */
/* @var $form yii\widgets\ActiveForm */

TabelasAsset::register($this);

?>

<div class="tabelas-form">

    <?php $form = ActiveForm::begin(); ?>

    <table class="table table-hover">
    	<tr>
    		<td colspan="4">Controle Interno</td>
    	</tr>
    </table>
	<table class="table table-hover">
    	<tr>
		    <td><?= $form->field($model, 'cridt')->textInput(['readonly' => true, 'value' => ($model->isNewRecord) ? date('Y-m-d') : $model['cridt'] ]);?></td>
		    <td><?= $form->field($model, 'criusu')->textInput(['maxlength' => true, 'readonly' => true, 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['apelido'] : $model['criusu'] ]);?></td>
		    <td><?= $form->field($model, 'dono')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'dono', 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['cnpj'] : $model['dono']]);?></td>
    	</tr>
    </table>
    
    <table class="table table-hover">
    	<tr>
    		<td colspan="4">Informações Gerais</td>
    	</tr>
    </table>
	<table class="table table-hover">
    	<tr>
		    <td><?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'id' => 'tabelas-nome']) ?></td>
		    <td><?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?></td>
    	</tr>
    </table>
    
     <table class="table table-hover">
    	<tr>
    		<td colspan="4">Informações do Cálculo</td>
    	</tr>
    </table>
	<table class="table table-hover">
    	<tr>
		    <td><?= $form->field($model, 'valorminimo')->textInput(['maxlength' => true, 'class' => 'form-control obrig-din']) ?></td>
		    <td><?= $form->field($model, 'pesominimo')->textInput(['maxlength' => true, 'class' => 'form-control obrig-peso']) ?></td>
		    <td><?= $form->field($model, 'excedente')->textInput(['maxlength' => true, 'class' => 'form-control obrig-din']) ?></td>
    	</tr>
    </table>

    <table class="table table-hover">
    	<tr>
    		<td colspan="4">Componentes do Frete</td>
    	</tr>
    </table>
	<table class="table table-hover">
    	<tr>
		    <td><?= $form->field($model, 'fretevalor')->textInput(['maxlength' => true, 'class' => 'form-control porcento', 'value' => $model->isNewRecord ? '0.00' : $model->fretevalor]) ?></td>
		    <td><?= $form->field($model, 'despacho')->textInput(['maxlength' => true, 'class' => 'form-control dinheiro', 'value' => $model->isNewRecord ? '0.00' : $model->despacho]) ?></td>
		    <td><?= $form->field($model, 'seccat')->textInput(['maxlength' => true, 'class' => 'form-control dinheiro', 'value' => $model->isNewRecord ? '0.00' : $model->seccat]) ?></td>
		    <td><?= $form->field($model, 'itr')->textInput(['maxlength' => true, 'class' => 'form-control dinheiro', 'value' => $model->isNewRecord ? '0.00' : $model->itr]) ?></td>
    	</tr>
    	<tr>
		    <td><?= $form->field($model, 'gris')->textInput(['maxlength' => true, 'class' => 'form-control porcento', 'value' => $model->isNewRecord ? '0.00' : $model->gris]) ?></td>
		    <td><?= $form->field($model, 'pedagio')->textInput(['maxlength' => true, 'class' => 'form-control dinheiro', 'value' => $model->isNewRecord ? '0.00' : $model->pedagio]) ?></td>
		    <td><?= $form->field($model, 'outros')->textInput(['maxlength' => true, 'class' => 'form-control dinheiro', 'value' => $model->isNewRecord ? '0.00' : $model->outros]) ?></td>
		    <td></td>
    	</tr>
    </table>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
