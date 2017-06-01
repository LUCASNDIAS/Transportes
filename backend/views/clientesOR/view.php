<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Clientes */

$this->title = substr($model->nome, 0, 30);
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//echo '<pre>';
//foreach ($model->clientesContatos as $contatos) {
//    var_dump($contatos->nome);
//    echo '----------------------------------------------';
//}
//echo '</pre>';

?>
<div class="clientes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Deletar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Confirmar exclusão?',
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
            'cnpj',
            'ie',
            //'endrua',
            //'endnro',
            //'endbairro',
            //'endcid',
            //'enduf',
        	//'endcep',
        	[
        		'label'=>'Endereço',
        		'value'=>$model->stringDataGrid('endereco')        			
            ],
            //'responsaveis',
            //'telefones',
            //'emails:email',
        	[
        		'label'=> 'Contatos',
        		'value'=> $model->stringDataGrid('contato')
        	],
        	[
        		'label'=>'Tabelas',
        		'value'=> ($nomeTabelas) ? implode(', ', $nomeTabelas) : 'Nenhuma tabela para o cliente.'	
            ],
            //'tabelas',
            [
            	'label'=> 'Status',
             	'value'=> ($model->status==1) ? 'ATIVO' : 'DESATIVADO',
             	'visible' => Yii::$app->user->can('admLND')
           	],
        ],
    ]) ?>

</div>