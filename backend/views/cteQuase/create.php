<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Cte */

$this->title = Yii::t('app', 'Create Cte');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ctes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cte-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
//        'modelNotas' => $modelNotas,
        'data'  => $data,
    ]) ?>

</div>
