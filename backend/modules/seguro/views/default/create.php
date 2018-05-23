<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\seguro\models\Seguro */

$this->title = Yii::t('app', 'Create Seguro');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Seguros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seguro-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
