<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\fatura\models\Fatura */

$this->title                   = Yii::t('app', 'Create Fatura');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faturas'), 'url' => [
        'index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-create">

    <?=
    $this->render('_form',
        [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ])
    ?>


</div>
