<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use backend\assets\CteAsset;
use yii\helpers\Url;

CteAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\modules\cte\models\Cte */

$this->title                   = Yii::t('app', 'Baixar  {modelClass}: ',
        [
        'modelClass' => 'Cte',
    ]).$model->numero;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ctes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

//echo '<pre>';
//return var_dump($modelsDimensoes);
?>
<div class="cte-baixar">

    <?php
    $form = ActiveForm::begin();
    ?>

    <div class="row">
        <div class="col-sm-4"><?= $form->field($model, 'ent_nome')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'ent_rg')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'ent_data')->textInput(['maxlength' => true, 'class' => 'form-control data']) ?></div>
        <div class="col-sm-2"><?= $form->field($model, 'ent_hora')->textInput(['maxlength' => true, 'class' => 'form-control hora']) ?></div>
    </div>

    <div class="form-group">
        <?=
        Html::submitButton(Yii::t('app',
                ($model->isNewRecord) ? 'Emitir' : 'Baixar'),
            ['class' => ($model->isNewRecord) ? 'btn btn-success' : 'btn btn-primary'])
        ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
