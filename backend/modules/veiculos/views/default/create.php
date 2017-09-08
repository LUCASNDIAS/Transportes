<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\Veiculos */

$this->title = Yii::t('app', 'Create Veiculos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Veiculos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="veiculos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
