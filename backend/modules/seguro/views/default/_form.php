<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\SeguroAsset;

SeguroAsset::register($this);
/* @var $this yii\web\View */
/* @var $model backend\modules\seguro\models\Seguro */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seguro-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Dados internos -->
    <div class="row hide">
        <div class="col-sm-4"><?=
            $form->field($model, 'cridt')->textInput(['readonly' => true,
                'value' => ($model->isNewRecord) ? date('Y-m-d') : $model['cridt']]);
            ?></div>
        <div class="col-sm-4"><?=
            $form->field($model, 'criusu')->textInput(['maxlength' => true,
                'readonly' => true, 'value' => ($model->isNewRecord) ? Yii::$app->user->identity['apelido']
                        : $model['criusu']]);
            ?></div>
        <div class="col-sm-4"><?=
            $form->field($model, 'dono')->textInput(['maxlength' => true,
                'readonly' => true, 'id' => 'dono', 'value' => ($model->isNewRecord)
                        ? Yii::$app->user->identity['cnpj'] : $model['dono']]);
            ?></div>
    </div>

    <div class="row">
        <div class="col-sm-6"><?= $form->field($model, 'xseg')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-6"><?= $form->field($model, 'cnpj')->textInput(['maxlength' => true]) ?></div>
    </div>

    <div class="row">
        <div class="col-sm-6"><?= $form->field($model, 'napol')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-6"><?= $form->field($model, 'naver')->textInput(['maxlength' => true]) ?></div>
    </div>

    <div class="form-group">
        <?=
        Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app',
                    'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
        ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
