<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\financeiro\models\Financeiro */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Financeiros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financeiro-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'id',
            'criusu',
            'cridt',
            'dono',
            'nome',
            'descricao',
            'emissao',
            'vencimento',
            'valor',
            'observacoes',
            'cpgto',
            'dtpgto',
            'sacado',
            'fatura',
            'status',
        ],
    ]) ?>

</div>
