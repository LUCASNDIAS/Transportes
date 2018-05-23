<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\Request;
use backend\commands\Basicos;

/* @var $this yii\web\View */
/* @var $model backend\models\Funcionarios */

$basicos = new Basicos();

$this->title = substr($model->nome, 0, 30);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Funcionarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="funcionarios-view">

    <h1><?php 
   		$fotos = new Request();
   		$arquivo = $fotos->baseUrl ."/img/funcionarios/" . $model->cpf . ".jpg";
   		echo Html::img($arquivo,['width'=> '180px']);
       ?></h1>
	
       <br/>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], [
        	'class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
            	'label'=> 'id',
             	'value'=> $model->id,
             	'visible' => Yii::$app->user->can('admLND')
           	],
            'cridt',
            [
            	'label'=> 'Criador',
             	'value'=> $model->criusu,
             	'visible' => Yii::$app->user->can('admLND')
           	],
            [
            	'label'=> 'Dono',
             	'value'=> $model->dono,
             	'visible' => Yii::$app->user->can('admLND')
           	],
            'nome',
        	[
        		'label'=>'Data de Nascimento',
        		'value'=>$basicos->formataData('ver',$model->datanascimento),
        	],
        	'cpf',
        	'rg',
        	[
        		'label'=>'CNH',
        		'value'=>$model->stringDataGrid('cnh')
        	],
            [
        		'label'=>'Endereço',
        		'value'=>$model->stringDataGrid('endereco')        			
            ],
            //'naturalidade',
            //'pai',
            //'mae',
        	[
        		'label'=>'Telefones',
        		'value'=>$model->stringDataGrid('telefone')
        	],            
            //'tel1',
            //'tel2',
            //'radio',
            'email:email',
            //'cnhnum',
            //'cnhcat',
            //'cnhval',
            //'pis',
            'cargo',
            //'salario',
            [
            	'label'=> 'Salário',
             	'value'=> $model->salario,
             	'visible' => Yii::$app->user->can('admLND')
           	],
            //'dtentrada',
  			//'img',
        ],
    ]) ?>

</div>
