<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\cotacao\models\Cotacao */

$this->title = Yii::t('app', 'Create Cotacao');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cotacaos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cotacao-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
