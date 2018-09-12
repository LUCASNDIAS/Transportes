<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\VeiculosServicoTipo */

$this->title = Yii::t('app', 'Create Veiculos Servico Tipo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Veiculos Servico Tipos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="veiculos-servico-tipo-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
