<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\FinanceiroAsset;

/* @var $this yii\web\View */
/* @var $model backend\modules\financeiro\models\Financeiro */
/* @var $form yii\widgets\ActiveForm */

FinanceiroAsset::register($this);

?>

<div class="financeiro-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Dados internos -->
    <div class="row hiden">
        <div class="col-sm-3"><?=
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
        <div class="col-sm-1"><?=
            $form->field($model, 'tipo')->textInput(['readonly' => true,
                'value' => ($model->isNewRecord) ? $_GET['t'] : $model->tipo])
            ?></div>
    </div>

    <div class="row">
        <div class="col-sm-6"><?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-6"><?= $form->field($model, 'descricao')->textInput([
                'maxlength' => true]) ?></div>
    </div>

    <div class="row">
        <div class="col-sm-4"><?= $form->field($model, 'emissao')->textInput(['class' => 'form-control data']) ?></div>
        <div class="col-sm-4"><?= $form->field($model, 'vencimento')->textInput(['class' => 'form-control data']) ?></div>
        <div class="col-sm-4"><?= $form->field($model, 'valor')->textInput(['class' => 'form-control dinheiro']) ?></div>
    </div>

    <div class="row">
        <div class="col-sm-12"><?= $form->field($model, 'observacoes')->textInput([
                'maxlength' => true]) ?></div>
    </div>

    <div class="row">
        <div class="col-sm-6"><?= $form->field($model, 'cpgto')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-6"><?= $form->field($model, 'dtpgto')->textInput(['class' => 'form-control data']) ?></div>
    </div>

    <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app',
            'Update'),
    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
