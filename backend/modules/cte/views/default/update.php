<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\cte\models\Cte */

$this->title                   = Yii::t('app', 'Update {modelClass}: ',
        [
        'modelClass' => 'Cte',
    ]).$model->numero;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ctes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

//echo '<pre>';
//return var_dump($modelsDimensoes);
?>
<div class="cte-update">

    <?=
    $this->render('_form',
        [
        'model' => $model,
        'modelCteVeiculo' => $modelCteVeiculo,
        'modelCteMotorista' => $modelCteMotorista,
        'data' => $data,
        'modelsDocumentos' => $modelsDocumentos,
        'modelsDimensoes' => $modelsDimensoes,
        'modelsComponentes' => $modelsComponentes,
        'veiculos' => $veiculos,
        'motoristas' => $motoristas,
    ])
    ?>

</div>
