<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use backend\assets\ClientesAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\Clientes */
/* @var $form yii\widgets\ActiveForm */

ClientesAsset::register($this);
?>

<div class="clientes-form">

<?php $form = ActiveForm::begin(); ?>

<?php 
$controleInterno = $form->field($model, 'cridt')->textInput(['readonly' => true, 'value' => ($model->isNewRecord) ? date('Y-m-d') : $model['cridt'] ]);
$controleInterno .= $form->field($model, 'criusu')->textInput(['maxlength' => true, 'readonly' => true, 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['apelido'] : $model['apelido'] ]);
$controleInterno .= $form->field($model, 'dono')->textInput(['maxlength' => true, 'readonly' => true, 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['cnpj'] : $model['cnpj']]);
$controleInterno .= $form->field($model, 'status')->textInput(['maxlength' => true, 'readonly' => true, 'value' => ($model->isNewRecord) ? '1' : $model['status'] ]);

$dadosGerais = $form->field($model, 'nome')->textInput(['maxlength' => true]);
$dadosGerais .= $form->field($model, 'cnpj')->textInput(['maxlength' => true]);
$dadosGerais .= $form->field($model, 'ie')->textInput(['maxlength' => true]);

$endereco = $form->field($model, 'endrua')->textInput(['maxlength' => true]);
$endereco .= $form->field($model, 'endnro')->textInput(['maxlength' => true]);
$endereco .= $form->field($model, 'endbairro')->textInput(['maxlength' => true]);
$endereco .= $form->field($model, 'endcid')->textInput(['maxlength' => true]);
$endereco .= $form->field($model, 'enduf')->textInput(['maxlength' => true]);
$endereco .= $form->field($model, 'endcep')->textInput(['maxlength' => true]);

$contatos = $form->field($model, 'responsaveis')->textInput(['maxlength' => true]);
$contatos .= $form->field($model, 'telefones')->textInput(['maxlength' => true]);
$contatos .= $form->field($model, 'emails')->textInput(['maxlength' => true]);

$tabelas = $form->field($model, 'tabelas')->textInput(['maxlength' => true]);

$salvar = "<div class='form-group'><p>";
$salvar	.= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
$salvar .= "</p></div>";
?>

<?php 
echo Tabs::widget([
    'items' => [
        [
            'label' => 'Controle Interno',
            'content' => $controleInterno,
            'active' => false
        ],
    	[
    		'label' => 'Dados Gerais',
    		'content' => $dadosGerais,
    		'active' => true
    	],
    	[
    		'label' => 'Endereço',
    		'content' => $endereco,
    	],
    	[
    		'label' => 'Contatos',
    		'content' => $contatos,
    	],
    	[
    		'label' => 'Tabelas',
    		'content' => $tabelas,
    	],
    	[
    		'label' => 'Salvar',
    		'content' => $salvar,
    	],    	
    ],
]);?>

    <div class="form-group">
        
    </div>

    <?php ActiveForm::end(); ?>

</div>