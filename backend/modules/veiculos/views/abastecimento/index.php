<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\veiculos\models\VeiculosAbastecimentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Veiculos Abastecimentos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="veiculos-abastecimento-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
            echo Html::a(Yii::t('app', 'Create Veiculos Abastecimento'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
//            'id',
//            'veiculo',
            [
                'label' => 'Veículo',
                'format' => 'ntext',
                'attribute'=>'veiculoPlaca',
                'value' => function($model) {
                    $placa = $model->veiculo0['placa'];
                    return $placa;
                }
            ],
            'odometro',
            'data',
            'combustivel',
            // 'posto',
            // 'cheio',
             'valor_total',
            // 'litros',


        ],
    ]); ?>
<?php Pjax::end(); ?></div>
