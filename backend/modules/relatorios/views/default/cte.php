<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Relatório - CT-e');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'CT-e'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relatorio-cte">

    <?= $this->render('_formcte'); ?>

</div>