<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Relatório Financeiro - Balanço');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Receber'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relatorio-pagar">

    <?= $this->render('_form',
        [
            'tp' => 'T'
        ]) ?>

</div>