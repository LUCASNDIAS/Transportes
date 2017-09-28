<?php

use yii\helpers\Html;
use backend\assets\CteEnviarAsset;

/* @var $this yii\web\View */
/* @var $model backend\modules\cte\models\Cte */

CteEnviarAsset::register($this);

$this->title                   = Yii::t('app', 'Enviar {modelClass}: ',
        [
        'modelClass' => 'Cte',
    ]).$model->numero;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ctes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->numero, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Gerar XML');
?>
<div class="cte-send">
    <?=
    Html::buttonInput('Confirmar transmissão do CT-e',
        [
        'id' => 'btn-enviar',
        'class' => 'btn btn-success',
        'n' => $model->id
    ])
    ?>
    <?= Html::a('Editar CT-e', ['/cte/default/update', 'id' => $model->id], ['class'=>'btn btn-primary']) ?>

    <br><br>
    <div class="row">
        <!-- Gerar XML -->
        <div class="col-md-4" id="bloco-gerar">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Gerar XML</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="progress progress-sm">
                        <div id="barra-gerar" class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="sr-only">20% Complete</span>
                        </div>
                    </div>

                    <p id="resultado-gerar">Aguardando confirmação de transmissão do CT-e.</p>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <!-- Assinar XML -->
        <div class="col-md-4" id="bloco-assinar">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Assinar XML</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="progress progress-sm">
                        <div id="barra-assinar" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="sr-only">20% Complete</span>
                        </div>
                    </div>

                    <p id="resultado-assinar">Aguardando o arquivo ser gerado</p>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <!-- Validar XML -->
        <div class="col-md-4" id="bloco-validar">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Validar XML</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="progress progress-sm">
                        <div id="barra-validar" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="sr-only">20% Complete</span>
                        </div>
                    </div>

                    <p id="resultado-validar">Aguardando assinatura.</p>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="row">
        <!-- Enviar XML -->
        <div class="col-md-6" id="bloco-enviar">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Enviar XML</h3><code> (Obs.: Pode ser que demore...)</code>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="progress progress-sm">
                        <div id="barra-enviar" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="sr-only">20% Complete</span>
                        </div>
                    </div>

                    <p id="resultado-enviar">Aguardando validação.</p>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <!-- Situação XML -->
        <div class="col-md-6" id="bloco-recibo">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Retorno da SEFAZ</h3><code> (Obs.: Pode ser que demore...)</code>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="progress progress-sm">
                        <div id="barra-recibo" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="sr-only">20% Complete</span>
                        </div>
                    </div>

                    <p id="resultado-recibo">Aguardando envio.</p>
                    <p id="motivo-erro" class="text-red"></p>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="row">
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

                    <p id="resultado-protocolo">CT-e não autorizado.</p>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <!-- PDF -->
        <div class="col-md-6" id="bloco-pdf">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Gerar PDF</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="progress progress-sm">
                        <div id="barra-pdf" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="sr-only">20% Complete</span>
                        </div>
                    </div>

                    <p id="resultado-pdf">CT-e não autorizado.</p>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

    </div>
    <div class="row hide">
        <div id="validar">Validar</div>
        <textarea style="border: 1px solid Gray; color: black;" cols="105" rows="15" name="txtCTe" id="txtCTe">
            
        </textarea>
        <div id="tbl-resultado">Tabela: </div>
        <div id="results">Resultado: </div>
        <div id="oculto">Hided: </div>
    </div>

</div>
