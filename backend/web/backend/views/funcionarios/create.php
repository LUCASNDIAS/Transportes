<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Funcionarios */

$this->title = Yii::t('app', 'Create Funcionarios');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Funcionarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="funcionarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
