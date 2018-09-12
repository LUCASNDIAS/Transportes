<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\veiculos\models\VeiculosServicoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Veiculos Servicos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="veiculos-servico-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Novo serviço'), ['create','tipo' => 'S'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Nova despesa'), ['create','tipo' => 'D'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
//            'id',
//            'cridt',
//            'criusu',
//            'dono',
            'veiculo',
            'odometro',
            'data',
            'tipo_servico',
            'valor_total',
            // 'parcelas',
            // 'primeiro_vencimento',
            // 'prox_odometro',
            // 'prox_data',
            // 'local',
            // 'detalhes',
            // 'observacoes',
            // 'financeiro',


        ],
    ]); ?>
<?php Pjax::end(); ?></div>
