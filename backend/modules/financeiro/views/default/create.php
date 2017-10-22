<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\financeiro\models\Financeiro */

$this->title = Yii::t('app', ($_GET['t'] == 'D') ? 'Lançar Despesa' : 'Lançar Receita');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Financeiros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financeiro-create">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
