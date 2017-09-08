<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\veiculos\models\VeiculosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="veiculos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'marca') ?>

    <?= $form->field($model, 'modelo') ?>

    <?= $form->field($model, 'cint') ?>

    <?= $form->field($model, 'renavam') ?>

    <?php // echo $form->field($model, 'placa') ?>

    <?php // echo $form->field($model, 'tara') ?>

    <?php // echo $form->field($model, 'capkg') ?>

    <?php // echo $form->field($model, 'capm3') ?>

    <?php // echo $form->field($model, 'tpprop') ?>

    <?php // echo $form->field($model, 'tpveic_id') ?>

    <?php // echo $form->field($model, 'tprod_id') ?>

    <?php // echo $form->field($model, 'tpcar_id') ?>

    <?php // echo $form->field($model, 'uf') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
