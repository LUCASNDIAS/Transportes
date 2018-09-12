<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\VeiculosServico */

$this->title = ($tipo_servico=='S') ? 'Novo Serviço' : 'Nova despesa';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Veiculos Servicos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="veiculos-servico-create">

    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data,
        'tipo_servico' => $tipo_servico,
        'tipos' => $tipos,
        'modelsPagamento' => $modelsPagamento,
    ]) ?>

</div>
