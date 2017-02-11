<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\FuncionariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Funcionarios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="funcionarios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Funcionarios'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'endrua',
            'endbairro',
            'endcep',
            // 'endcid',
            // 'enduf',
            // 'naturalidade',
            // 'datanascimento',
            // 'pai',
            // 'mae',
            // 'tel1',
            // 'tel2',
            // 'radio',
            // 'email:email',
            // 'rg',
            // 'cpf',
            // 'cnhnum',
            // 'cnhcat',
            // 'cnhval',
            // 'pis',
            // 'cargo',
            // 'salario',
            // 'dtentrada',
            // 'criusu',
            // 'cridt',
            // 'img',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
