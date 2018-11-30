<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\fatura\models\FaturaBoleto */

$this->title = Yii::t('app', 'Create Fatura Boleto');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fatura Boletos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-boleto-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelFatura' => $modelFatura,
    ]) ?>

</div>
