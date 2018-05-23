<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Minutas */

$this->title = Yii::t('app', 'Create Minutas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Minutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//var_dump($formulario);
?>
<div class="minutas-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
