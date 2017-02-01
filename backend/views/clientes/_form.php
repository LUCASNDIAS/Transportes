<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;
use backend\assets\ClientesAsset;
use yii\jui\AutoComplete;
use backend\models\Tabelas;
use yii\helpers\ArrayHelper;
use backend\models\Clientes;

/* @var $this yii\web\View */
/* @var $model backend\models\Clientes */
/* @var $form yii\widgets\ActiveForm */

ClientesAsset::register($this);

?>

<div class="clientes-form">

<?php $form = ActiveForm::begin([
    'id' => 'clientes-form',
	'enableAjaxValidation' => true,
]); ?>
<br /><br />
		<table class="table table-hover">
            <tr>
                <td>Controle Interno</td>
            </tr>
         </table>
		<table class="table table-hover">
            <tr>
                <td><?= $form->field($model, 'cridt')->textInput(['readonly' => true, 'value' => ($model->isNewRecord) ? date('Y-m-d') : $model['cridt'] ]);?></td>
                <td><?= $form->field($model, 'criusu')->textInput(['maxlength' => true, 'readonly' => true, 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['apelido'] : $model['criusu'] ]);?></td>
                <td><?= $form->field($model, 'dono')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'dono', 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['cnpj'] : $model['dono']]);?></td>
                <td><?= $form->field($model, 'status')->textInput(['maxlength' => true, 'readonly' => true, 'value' => ($model->isNewRecord) ? '1' : $model['status'] ]);?></td>
            </tr>
         </table>
         <table class="table table-hover">
            <tr>
                <td>Dados Pessoais</td>
            </tr>
         </table>
		<table class="table table-hover">
            <tr>
                <td colspan="2"><?= $form->field($model, 'nome')->textInput(['maxlength' => true])->hint('Razão Social');?></td>
            </tr>
            <tr>
                <td><?= $form->field($model, 'cnpj')->textInput(['maxlength' => true, 'enableAjaxValidation' => true])->hint('Somente números');?></td>
                <td><?= $form->field($model, 'ie')->textInput(['maxlength' => true])->hint('Números ou \'ISENTO\'');?></td>
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
		<div class="linhas">
			<?php 
			$z = 0;
			
			if(!$model->isNewRecord) {
				
			$contatonomes = explode('|', $model->responsaveis);
			$contatotelefones = explode('|', $model->telefones);
			$contatoemails = explode('|', $model->emails);
			
			$i = 0;
			
			foreach ($contatonomes as $contatonome) {
				if ($contatonome!='') {
				?>
			<table class="table table-hover">
				<tr>
					<td width="40%">
						<div class="form-group">
							<label class="control-label" for="clientes-responsavel">Nome</label>
							<?= Html::input('text','responsavel[]',$contatonome,['class' => 'form-control', 'id' => 'clientes-responsavel0']);?>
							<p class="help-block help-block-error"></p>
						</div>
					</td>
					<td width="20%">
						<div class="form-group">
							<label class="control-label" for="clientes-telefone">Telefone</label>
							<?= Html::input('text','telefone[]',$contatotelefones[$i],['class' => 'form-control telefone', 'id' => 'clientes-telefone0']);?>
							<p class="help-block help-block-error"></p>
						</div>
					</td>
					<td width="40%">
						<div class="form-group">
							<label class="control-label" for="clientes-email">Email</label>
							<?= Html::input('text','email[]',$contatoemails[$i],['class' => 'form-control', 'id' => 'clientes-email0']);?>
							<p class="help-block help-block-error"></p>
						</div>
					</td>
				</tr>
			</table>
			<?php $z++; } //if em branco
				 $i++; 
				} //foreach
			 } //if update
		     if ($z == 0){
			 ?>
		    <table class="table table-hover">
				<tr>
					<td width="40%">
						<div class="form-group">
							<label class="control-label" for="clientes-responsavel">Nome</label>
							<?= Html::input('text','responsavel[]',null,['class' => 'form-control', 'id' => 'clientes-responsavel0']);?>
							<p class="help-block help-block-error"></p>
						</div>
					</td>
					<td width="20%">
						<div class="form-group">
							<label class="control-label" for="clientes-telefone">Telefone</label>
							<?= Html::input('text','telefone[]',null,['class' => 'form-control telefone', 'id' => 'clientes-telefone0']);?>
							<p class="help-block help-block-error"></p>
						</div>
					</td>
					<td width="40%">
						<div class="form-group">
							<label class="control-label" for="clientes-email">Email</label>
							<?= Html::input('text','email[]',null,['class' => 'form-control', 'id' => 'clientes-email0']);?>
							<p class="help-block help-block-error"></p>
						</div>
					</td>
				</tr>
			</table>
			<?php } ?>
		</div>
		<div class="hide">
			<table class="table table-hover">
				<tr>
					<td width="40%"><?= $form->field($model, 'responsaveis')->textInput(['maxlength' => true, 'id' => 'responsaveis']);?></td>
					<td width="20%"><?= $form->field($model, 'telefones')->textInput(['maxlength' => true, 'id' => 'telefones']);?></td>
					<td width="40%"><?= $form->field($model, 'emails')->textInput(['maxlength' => true, 'id' => 'emails']);?></td>
				</tr>
			</table>
		</div>
		<span class="label label-success adicionarCampo" id="linhas">Adicionar outro Contato</span>
		<br /><br />
		<div class="linhasTabelas">
			<table class="table table-hover">
				<tr>
					<?php for($i=0;$i<=4;$i++){ ?>
					<td>
						<div class="form-group">
							<label class="control-label" for="tabela">Tabela</label>
							<?php 
							echo AutoComplete::widget([
							    'name' => 'tabelas-auto[]',
								'id' => 'tabelaAuto'.$i,
								'value' => (isset($nomeTabelas[$i])) ? $nomeTabelas[$i] : '',
								'options' => [
									'class' => 'form-control',
								],
							    'clientOptions' => [
							        'source'=> (isset($tabelas)) ? $tabelas : ['NENHUMA TABELA'],
							    ],
							]); ?>
							<p class="help-block help-block-error"></p>
						</div>
					</td>
					<?php } ?>
				</tr>
			</table>
		</div>
		<div class="hide">
			<table class="table table-hover">
				<tr>
					<td><?= $form->field($model, 'tabelas')->textInput(['maxlength' => true, 'id' => 'tabelas', 'enableAjaxValidation' => true]);?></td>
				</tr>
			</table>
		</div>
	<br><br> 
	<div class="form-group" align="center">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Salvar Informações') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-valida' : 'btn btn-primary btn-valida', 'id' => $model->isNewRecord ? 'submitCreate' : 'submitUpdate']);?>
	</div>

    <?php ActiveForm::end(); ?>

</div>