<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\mensagens\models\Mensagens */

$this->title = Yii::t('app', 'Create Mensagens');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mensagens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensagens-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'usuarios' => $usuarios
    ]) ?>

</div>
