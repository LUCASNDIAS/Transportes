<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\FuncionariosAsset;
use backend\commands\Basicos;

/* @var $this yii\web\View */
/* @var $model backend\models\Funcionarios */
/* @var $form yii\widgets\ActiveForm */

$basicos = new Basicos();

FuncionariosAsset::register($this);
?>

<div class="funcionarios-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
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
                <td colspan="4">Dados Pessoais</td>
            </tr>
         </table>
         <table class="table table-hover">
            <tr>
                <td colspan="3"><?= $form->field($model, 'nome')->textInput(['maxlength' => true])->hint('Razão Social');?></td>
            </tr>
            <tr>
                <td><?= $form->field($model, 'cpf')->textInput(['maxlength' => true])->hint('Somente números');?></td>
                <td><?= $form->field($model, 'datanascimento')->textInput(['maxlength' => true,'class'=>'form-control data', 'value'=>($model->isNewRecord) ? '' : $basicos->formataData('ver',$model->datanascimento)])->hint('Formato: dd/mm/aaaa');?></td>
                <td><?= $form->field($model, 'rg')->textInput(['maxlength' => true]);?></td>
            </tr>
            <tr>
                <td><?= $form->field($model, 'cnhnum')->textInput(['maxlength' => true])->hint('Somente números'); ?></td>
                <td><?= $form->field($model, 'cnhcat')->textInput(['maxlength' => true]); ?></td>
                <td><?= $form->field($model, 'cnhval')->textInput(['class'=>'form-control data', 'value'=>($model->isNewRecord) ? '' : $basicos->formataData('ver',$model->cnhval)])->hint('Formato: dd/mm/aaaa'); ?></td>
            </tr>
            <tr>
                <td colspan="2"><?= $form->field($model, 'cargo')->textInput(['maxlength' => true]) ?></td>
                <td><?= $form->field($model, 'salario')->textInput(['maxlength' => true, 'class'=>'form-control dinheiro']) ?></td>
            </tr>
         </table>
         <table class="table table-hover">
            <tr>
                <td colspan="4">Endereço</td>
            </tr>
         </table>
         <table class="table table-hover">
			<tr>
				<td width="15%"><?= $form->field($model, 'endcep')->textInput(['maxlength' => true, 'class' => 'form-control cep'])->hint('Somente números');?></td>
				<td width="10%"><?= Html::a('<i class="fa fa-search"></i> Buscar','#!',['class'=>'btn btn-app']); ?><td>
				<td width="60%"><?= $form->field($model, 'endrua')->textInput(['maxlength' => true]);?></td>
				<td width="15%"><?= $form->field($model, 'endnro')->textInput(['maxlength' => true]);?></td>
			</tr>
		</table>
		<table class="table table-hover">		
			<tr>
				<td width="30%"><?= $form->field($model, 'endbairro')->textInput(['maxlength' => true]);?></td>
				<td width="40%"><?= $form->field($model, 'endcid')->textInput(['maxlength' => true]);?></td>
				<td width="10%"><?= $form->field($model, 'enduf')->textInput(['maxlength' => true]);?></td>
			</tr>
		</table>
        <table class="table table-hover">
            <tr>
                <td colspan="4">Contato</td>
            </tr>
        </table>
        <table class="table table-hover">
			<tr>
				<td width="20%"><?= $form->field($model, 'tel1')->textInput(['maxlength' => true, 'class'=>'form-control telefone']) ?></td>
				<td width="20%"><?= $form->field($model, 'tel2')->textInput(['maxlength' => true, 'class'=>'form-control telefone']) ?><td>
				<td width="20%"><?= $form->field($model, 'radio')->textInput(['maxlength' => true, 'class'=>'form-control telefone']) ?></td>
				<td width="40%"><?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></td>
			</tr>
		</table>
		<table class="table table-hover">
            <tr>
                <td colspan="4">Foto</td>
            </tr>
        </table>
        <table class="table table-hover">
			<tr>
				<td><?= $form->field($model, 'img')->fileInput() ?></td>
			</tr>
		</table>
		

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
