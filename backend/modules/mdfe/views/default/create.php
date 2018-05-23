<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\mdfe\models\Mdfe */

$this->title = Yii::t('app', 'Create Mdfe');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mdves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mdfe-create">

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
//        'ctes' => $ctes
    ]) ?>

</div>
