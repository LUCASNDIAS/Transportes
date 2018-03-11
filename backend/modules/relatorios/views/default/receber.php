<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Relatório Financeiro - Receber');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Receber'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relatorio-receber">

    <?= $this->render('_form',
        [
            'tp' => 'R'
        ]) ?>

</div>