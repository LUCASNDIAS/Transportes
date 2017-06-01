<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\clientes\models\Clientes */

$this->title = Yii::t('app', 'Create Clientes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsContatos' => $modelsContatos,
        'modelsTabelas' => $modelsTabelas,
        'data' => $data,
    ]) ?>

</div>
