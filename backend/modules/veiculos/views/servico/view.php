<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\VeiculosServico */

$this->title = $model->local . ' - ' . $model->veiculo0->placa;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Veiculos Servicos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="veiculos-servico-view">

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
            'cridt',
            'criusu',
            'dono',
            'veiculo',
            'odometro',
            'data',
            'tipo_servico',
            'valor_total',
            'parcelas',
//            'valor_parcela',
//            'primeiro_vencimento',
            'prox_odometro',
            'prox_data',
            'local',
            'detalhes',
            'observacoes',
//            'financeiro',
        ],
    ]) ?>

</div>
