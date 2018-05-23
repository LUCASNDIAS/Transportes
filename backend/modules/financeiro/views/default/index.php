<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\financeiro\models\FinanceiroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Financeiro');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financeiro-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', ($_GET['t'] == 'D') ? 'Lançar Despesa' : 'Lançar Receita'), ['create', 't' => $_GET['t']], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'criusu',
//            'cridt',
//            'dono',
            'nome',
            'descricao',
            // 'emissao',
            'vencimento',
             'valor',
            // 'observacoes',
            // 'cpgto',
            // 'dtpgto',
            // 'sacado',
            // 'fatura',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
