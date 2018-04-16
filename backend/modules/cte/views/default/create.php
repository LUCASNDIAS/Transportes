<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\cte\models\Cte */

$this->title                   = Yii::t('app', 'Create Cte');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ctes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cte-create">

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
        'modelCteDocant' => $modelCteDocant
    ])
    ?>

</div>
