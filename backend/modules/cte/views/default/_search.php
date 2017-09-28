<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\modules\cte\models\CteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cte-search">

    <?php
    $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => [
                'data-pjax' => false
            ],
    ]);
    ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'numero'); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'dtemissao'); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'notaChave'); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->dropDownList([
                '' => 'TODOS',
                'AUTORIZADO' => 'AUTORIZADO',
                'CANCELADO' => 'CANCELADO',
                'FATURADO' => 'FATURADO',
                'SALVO' => 'SALVO',                
            ]); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'remetente')->widget(AutoComplete::classname(),[
                'clientOptions' => [
                    'source' => $data,
                    'autoFill' => true,
                    'minLength' => 4
                ],
                'options' => [
                    'class' => 'form-control'
                ],
            ]); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'destinatario')->widget(AutoComplete::classname(),[
                'clientOptions' => [
                    'source' => $data,
                    'autoFill' => true,
                    'minLength' => 4
                ],
                'options' => [
                    'class' => 'form-control'
                ],
            ]); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'expedidor')->widget(AutoComplete::classname(),[
                'clientOptions' => [
                    'source' => $data,
                    'autoFill' => true,
                    'minLength' => 4
                ],
                'options' => [
                    'class' => 'form-control'
                ],
            ]); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'recebedor')->widget(AutoComplete::classname(),[
                'clientOptions' => [
                    'source' => $data,
                    'autoFill' => true,
                    'minLength' => 4
                ],
                'options' => [
                    'class' => 'form-control'
                ],
            ]); ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'tomador')->widget(AutoComplete::classname(),[
                'clientOptions' => [
                    'source' => $data,
                    'autoFill' => true,
                    'minLength' => 4
                ],
                'options' => [
                    'class' => 'form-control'
                ],
            ]); ?>
        </div>
    </div>

    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'dono') ?>

    <?php // echo $form->field($model, 'cridt') ?>

    <?php // echo $form->field($model, 'criusu') ?>

    <?php // echo $form->field($model, 'ambiente') ?>

    <?php // echo $form->field($model, 'chave') ?>

    <?php // echo $form->field($model, 'modelo') ?>

    <?php // echo $form->field($model, 'serie') ?>

    <?php // echo $form->field($model, 'numero') ?>

    <?php // echo $form->field($model, 'dtemissao') ?>

    <?php // echo $form->field($model, 'cct') ?>

    <?php // echo $form->field($model, 'cfop') ?>

    <?php // echo $form->field($model, 'natop') ?>

    <?php // echo $form->field($model, 'forpag') ?>

    <?php // echo $form->field($model, 'tpemis') ?>

    <?php // echo $form->field($model, 'tpcte') ?>

    <?php // echo $form->field($model, 'refcte') ?>

    <?php // echo $form->field($model, 'cmunenv') ?>

    <?php // echo $form->field($model, 'xmunenv') ?>

    <?php // echo $form->field($model, 'ufenv') ?>

    <?php // echo $form->field($model, 'modal') ?>

    <?php // echo $form->field($model, 'tpserv') ?>

    <?php // echo $form->field($model, 'cmunini') ?>

    <?php // echo $form->field($model, 'xmunini') ?>

    <?php // echo $form->field($model, 'ufini') ?>

    <?php // echo $form->field($model, 'cmunfim') ?>

    <?php // echo $form->field($model, 'xmunfim') ?>

    <?php // echo $form->field($model, 'uffim') ?>

    <?php // echo $form->field($model, 'retira') ?>

    <?php // echo $form->field($model, 'xdetretira') ?>

    <?php // echo $form->field($model, 'dhcont') ?>

    <?php // echo $form->field($model, 'xjust') ?>

    <?php // echo $form->field($model, 'toma') ?>

    <?php // echo $form->field($model, 'tomador') ?>

    <?php // echo $form->field($model, 'remetente') ?>

    <?php // echo $form->field($model, 'destinatario') ?>

    <?php // echo $form->field($model, 'recebedor') ?>

    <?php // echo $form->field($model, 'expedidor') ?>

    <?php // echo $form->field($model, 'vtprest') ?>

    <?php // echo $form->field($model, 'vrec') ?>

    <?php // echo $form->field($model, 'cst') ?>

    <?php // echo $form->field($model, 'predbc') ?>

    <?php // echo $form->field($model, 'vbv') ?>

    <?php // echo $form->field($model, 'picms') ?>

    <?php // echo $form->field($model, 'vicms') ?>

    <?php // echo $form->field($model, 'vbcstret') ?>

    <?php // echo $form->field($model, 'vicmsret') ?>

    <?php // echo $form->field($model, 'picmsret') ?>

    <?php // echo $form->field($model, 'vcred') ?>

    <?php // echo $form->field($model, 'vtottrib') ?>

    <?php // echo $form->field($model, 'outrauf') ?>

    <?php // echo $form->field($model, 'vcarga') ?>

    <?php // echo $form->field($model, 'predpred') ?>

    <?php // echo $form->field($model, 'xoutcat') ?>

    <?php // echo $form->field($model, 'respseg') ?>

    <?php // echo $form->field($model, 'xseg') ?>

    <?php // echo $form->field($model, 'napol') ?>

    <?php // echo $form->field($model, 'rntrc') ?>

    <?php // echo $form->field($model, 'dprev') ?>

    <?php // echo $form->field($model, 'lota') ?>

    <?php // echo $form->field($model, 'status')  ?>

    <div class="form-group">
        <?=
        Html::submitButton(Yii::t('app', 'Search'),
            ['class' => 'btn btn-primary'])
        ?>
        <?=
        Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default'])
        ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
