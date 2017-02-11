 <?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Clientes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Clientes'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
    
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
        	['class' => 'yii\grid\ActionColumn'],
            //'id',
            //'cridt',
            //'criusu',
            //'dono',
            'nome',
            'cnpj',
        	//['label'=>'Endereco',
        	//'value'=>function($data) {
        	//	return $data->stringDataGrid('endereco');
        	//}],
        	['label'=>'Telefone',
        	'value'=>function($data) {
        		return $data->stringDataGrid();
        	}],
            // 'ie',
            // 'endrua',
            // 'endnro',
            // 'endbairro',
            // 'endcid',
            // 'enduf',
            // 'endcep',
            //'responsaveis',
            //'telefones',
            // 'emails:email',
            // 'tabelas',
            // 'status',
        		
           
        ],
    ]); ?>
    
<?php Pjax::end(); ?>
</div>
