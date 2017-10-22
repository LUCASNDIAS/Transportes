<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\ordemcoleta\models\OrdemColeta */

$this->title = Yii::t('app', 'Create Ordem Coleta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ordem Coletas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ordem-coleta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
