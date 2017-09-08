<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\cte\models\Cte */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ctes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cte-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'dono',
            'cridt',
            'criusu',
            'ambiente',
            'chave',
            'modelo',
            'serie',
            'numero',
            'dtemissao',
            'cct',
            'cfop',
            'natop',
            'forpag',
            'tpemis',
            'tpcte',
            'refcte',
            'cmunenv',
            'xmunenv',
            'ufenv',
            'modal',
            'tpserv',
            'cmunini',
            'xmunini',
            'ufini',
            'cmunfim',
            'xmunfim',
            'uffim',
            'retira',
            'xdetretira',
            'dhcont',
            'xjust',
            'toma',
            'tomador',
            'remetente',
            'destinatario',
            'recebedor',
            'expedidor',
            'vtprest',
            'vrec',
            'cst',
            'predbc',
            'vbv',
            'picms',
            'vicms',
            'vbcstret',
            'vicmsret',
            'picmsret',
            'vcred',
            'vtottrib',
            'outrauf',
            'vcarga',
            'predpred',
            'xoutcat',
            'respseg',
            'xseg',
            'napol',
            'rntrc',
            'dprev',
            'lota',
            'status',
        ],
    ]) ?>

</div>
