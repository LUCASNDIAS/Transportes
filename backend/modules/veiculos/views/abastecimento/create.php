<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\VeiculosAbastecimento */

$this->title = Yii::t('app', 'Create Veiculos Abastecimento');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Veiculos Abastecimentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="veiculos-abastecimento-create">

    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data
    ]) ?>

</div>
