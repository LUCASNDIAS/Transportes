<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\FaturaCteAsset as FaturaAsset;
use yii\jui\AutoComplete;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\fatura\models\Fatura */
/* @var $form yii\widgets\ActiveForm */

FaturaAsset::register($this);
?>

<div class="fatura-form">



    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Dados Gerais</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Documentos</a></li>
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Gerar</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <?php $form = ActiveForm::begin(); ?>
                    <!-- Dados internos -->
                    <div class="row hiden">
                        <div class="col-sm-4"><?=
                            $form->field($model, 'cridt')->textInput(['readonly' => true,
                                'value' => ($model->isNewRecord) ? date('Y-m-d')
                                        : $model['cridt']]);
                            ?></div>
                        <div class="col-sm-4"><?=
                            $form->field($model, 'criusu')->textInput(['maxlength' => true,
                                'readonly' => true, 'value' => ($model->isNewRecord)
                                        ? Yii::$app->user->identity['apelido'] : $model['criusu']]);
                            ?></div>
                        <div class="col-sm-4"><?=
                            $form->field($model, 'dono')->textInput(['maxlength' => true,
                                'readonly' => true, 'id' => 'dono', 'value' => ($model->isNewRecord)
                                        ? Yii::$app->user->identity['cnpj'] : $model['dono']]);
                            ?></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4"><?=
                            $form->field($model, 'tipo')->dropDownList([
                                'CTE' => 'CT-e',
//                                'MINUTA' => 'Minuta'
                                ])
                            ?></div>
                        <div class="col-sm-4"><?=
                            $form->field($model, 'sacado')->widget(AutoComplete::classname(),
                                [
                                'clientOptions' => [
                                    'source' => Url::to(['/ajax/seleciona-clientes']),
                                    'autoFill' => true,
                                    'minLength' => 4
                                ],
                                'options' => [
                                    'class' => 'form-control'
                                ],
                            ]);
                            ?></div>                        
                        <div class="col-sm-4"><?= $form->field($model, 'numero')->textInput() ?></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2"><?=
                            $form->field($model, 'emissao')->textInput([
                                'class' => 'form-control data',
                                'value' => ($model->isNewRecord) ? date('d/m/Y')
                                        : $model->emissao])
                            ?></div>
                        <div class="col-sm-2"><?=
                            $form->field($model, 'vencimento')->textInput([
                                'class' => 'form-control data'])
                            ?></div>
                        <div class="col-sm-8"><?=
                            $form->field($model, 'observacoes')->textInput([
                                'maxlength' => true])
                            ?></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <?=Html::textInput('embarques', '', ['class' => 'form-control hide', 'id' => 'embarques']); ?>
                        </div>
                    </div>

                    <div class="form-group hide">
                        <?=
                        Html::submitButton($model->isNewRecord ? Yii::t('app',
                                    'Create') : Yii::t('app', 'Update'),
                            [
                                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                                'id' => 'gerar-fatura'
                            ])
                        ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
                <div class="tab-pane" id="tab_2">
                    <?php Pjax::begin(); ?>
                    <?=
                    GridView::widget([
                        'id' => 'idGridView',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
                            ['class' => 'yii\grid\CheckboxColumn'],
//                            'id',
                            'numero',
                            'remetente',
                            'destinatario',
                            'tomador',
                            'cmunenv',
                            'vtprest',
                            ['class' => 'yii\grid\ActionColumn',],
                        ],
                    ]);
                    ?>
                    <?php Pjax::end(); ?>

                </div>
                <div class="tab-pane" id="tab_3">
                    <?= Html::button('Gerar', [
                        'class' => 'btn btn-success',
                        'id' => 'gerar-fake'
                    ]); ?>
                </div>
            </div>
        </div>
    </div>



</div>
