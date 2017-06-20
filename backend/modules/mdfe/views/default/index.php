<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\mdfe\models\MdfeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mdves');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mdfe-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Mdfe'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dono',
            'cridt',
            'criusu',
            'chave',
            // 'modelo',
            // 'serie',
            // 'numero',
            // 'dtemissao',
            // 'dtinicio',
            // 'uf',
            // 'tipoemitente',
            // 'modalidade',
            // 'formaemissao',
            // 'ufcarga',
            // 'ufdescarga',
            // 'rntrc',
            // 'ciot',
            // 'placa',
            // 'qtdecte',
            // 'qtdenfe',
            // 'qtdenf',
            // 'valormercadoria',
            // 'unidademedida',
            // 'pesomercadoria',
            // 'inffisco',
            // 'infcontribuinte',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
