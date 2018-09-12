<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\CteCancelAsset;

CteCancelAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\cte\models\CteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cancelar CT-e: ' . $model->numero);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cte-cancel">
    <?php
    $form = ActiveForm::begin([
        'id' => 'cancel-form'
    ]);
    ?>

    <div class="row">
        <div class="col-sm-6">
            Chave: <?= Html::input('text', 'chave', $model->chave,
                ['class' => 'form-control', 'readonly' => true]);
            ?>
        </div>

        <div class="col-sm-6">
            Protocolo: <?php echo Html::input('text', 'protocolo',
                $model->cteProtocolos[0]->nprot,
                ['class' => 'form-control', 'readonly' => true]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-10">
            Justificativa: <?php echo Html::input('text', 'motivo', '',
                ['class' => 'form-control', 'id' => 'motivo']);
            ?>
        </div>

        <div class="col-sm-2">
            <br/><?= Html::button('Cancelar CT-e', [
                'class' => 'btn btn-danger',
                'id' => 'btn-enviar',
                'n' => $model->id
            ]) ?>
        </div>
    </div>

    <br>
    <div class="row">
        <!-- Enviar Cancelamento -->
        <div class="col-md-6" id="bloco-enviar">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Enviar Cancelamento</h3><code> (Obs.: Pode ser que demore...)</code>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="progress progress-sm">
                        <div id="barra-enviar" class="progress-bar progress-bar-primary progress-bar-striped"
                             role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                             style="width: 100%">
                            <span class="sr-only">20% Complete</span>
                        </div>
                    </div>

                    <p id="resultado-enviar">Aguardando transmissão.</p>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <!-- Protocolo XML -->
        <div class="col-md-6" id="bloco-protocolo">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Adiciona protocolo</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="progress progress-sm">
                        <div id="barra-protocolo" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="sr-only">20% Complete</span>
                        </div>
                    </div>

                    <p id="resultado-protocolo">Aguardando retorno da SEFAZ.</p>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <br><br>
            <p>
                <?php
                if (!empty($retorno)) {
                    if ($retorno['cStat'] != '135') {
                        echo $retorno['cStat'] . ' - ' . $retorno['xMotivo'];
                    } else {
                        echo 'CT-e cancelado com sucesso.';
                    }
                }
                ?>
            </p>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
