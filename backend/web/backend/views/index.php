<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Clientes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'cridt',
            'criusu',
            'dono',
            'nome',
            // 'cnpj',
            // 'ie',
            // 'endrua',
            // 'endnro',
            // 'endbairro',
            // 'endcid',
            // 'enduf',
            // 'endcep',
            // 'responsaveis',
            // 'telefones',
            // 'emails:email',
            // 'tabelas',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
