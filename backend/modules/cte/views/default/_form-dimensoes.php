<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
?>


<?php
DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-dimensao',
    'widgetItem' => '.dimensao-item',
    'limit' => 4,
    'min' => 1,
    'insertButton' => '.add-dimensao',
    'deleteButton' => '.remove-dimensao',
    'model' => $modelsDimensoes[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'altura',
        'largur',
        'comprimento',
        'volumes',
    ],
]);
?>

<div class="panel panel-default">

        <div class="panel-heading">
            <i class="fa fa-road"></i> Dimensões / Volumes
            <button type="button" class="pull-right add-dimensao btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Dimensao</button>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body container-dimensao"><!-- widgetContainer -->

            <?php foreach ($modelsDimensoes as $index2 => $modelDimensoes): ?>

                <div class="dimensao-item panel panel-default"><!-- widgetBody -->

                    <div class="panel-body">

                        <?php
                        // necessary for update action.

                        if (!$modelDimensoes->isNewRecord) {

                            echo Html::activeHiddenInput($modelDimensoes,
                                "[{$index}][{$index2}]id");
                        }
                        ?>

                        <div class="row">
                            <div class="col-sm-3">
                                <?= $form->field($modelDimensoes,
                                    "[{$index}][{$index2}]altura")->textInput(['class' => 'form-control dimensao'])
                                ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($modelDimensoes,
                                    "[{$index}][{$index2}]largura")->textInput(['class' => 'form-control dimensao'])
                                ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($modelDimensoes,
                                    "[{$index}][{$index2}]comprimento")->textInput(['class' => 'form-control dimensao'])
                                ?>
                            </div>
                            <div class="col-sm-2">
                                <?= $form->field($modelDimensoes,
                                    "[{$index}][{$index2}]volumes")->textInput(['class' => "form-control nfvol"])
                                ?>
                            </div>
                            <div class="col-sm-1">
                                <button type="button" class="pull-right remove-dimensao btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                            </div>

                        </div>

                        <!-- end:row -->

                    </div>

                </div>

<?php endforeach; ?>

        </div>

    </div>

<?php DynamicFormWidget::end(); ?>