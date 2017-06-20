<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\mdfe\models\MdfeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mdfe-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'dono') ?>

    <?= $form->field($model, 'cridt') ?>

    <?= $form->field($model, 'criusu') ?>

    <?= $form->field($model, 'chave') ?>

    <?php // echo $form->field($model, 'modelo') ?>

    <?php // echo $form->field($model, 'serie') ?>

    <?php // echo $form->field($model, 'numero') ?>

    <?php // echo $form->field($model, 'dtemissao') ?>

    <?php // echo $form->field($model, 'dtinicio') ?>

    <?php // echo $form->field($model, 'uf') ?>

    <?php // echo $form->field($model, 'tipoemitente') ?>

    <?php // echo $form->field($model, 'modalidade') ?>

    <?php // echo $form->field($model, 'formaemissao') ?>

    <?php // echo $form->field($model, 'ufcarga') ?>

    <?php // echo $form->field($model, 'ufdescarga') ?>

    <?php // echo $form->field($model, 'rntrc') ?>

    <?php // echo $form->field($model, 'ciot') ?>

    <?php // echo $form->field($model, 'placa') ?>

    <?php // echo $form->field($model, 'qtdecte') ?>

    <?php // echo $form->field($model, 'qtdenfe') ?>

    <?php // echo $form->field($model, 'qtdenf') ?>

    <?php // echo $form->field($model, 'valormercadoria') ?>

    <?php // echo $form->field($model, 'unidademedida') ?>

    <?php // echo $form->field($model, 'pesomercadoria') ?>

    <?php // echo $form->field($model, 'inffisco') ?>

    <?php // echo $form->field($model, 'infcontribuinte') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
