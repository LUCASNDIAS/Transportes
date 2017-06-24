<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\mdfe\models\Mdfe */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Mdfe',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mdves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="mdfe-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsCarregamento' => $modelsCarregamento,
        'modelsCondutor' => $modelsCondutor,
        'modelsDescarregamento' => $modelsDescarregamento,
        'modelsDocumentos' => $modelsDocumentos,
        'modelsPercurso' => $modelsPercurso,
        'municipios' => $municipios,
        'ufs' => $ufs,
        'condutores' => $condutores,
    ]) ?>

</div>
