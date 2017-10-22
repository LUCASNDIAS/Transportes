<?php

use backend\assets\OrdemColetaAsset;
use yii\helpers\Html;
use backend\commands\Basicos;
use yii\helpers\Url;

OrdemColetaAsset::register($this);

$this->title = Yii::t('app', 'Enviar Ordem de Coleta ') . str_pad($model->numero, 6, 0, STR_PAD_LEFT);
$basicos = new Basicos();
?>

<?= Html::beginForm([Url::to(['/ordemcoleta/default/send']), 'id' => $model->id], 'post', ['enctype' => 'multipart/form-data', 'name' => 'form-envio', 'id' => $model->id]) ?>

<table class="table table-hover">
    <tr>
        <td>Confira o email dos envolvidos</td>
    </tr>
</table>
<table class="table table-hover">
    <tr>
        <td>
            <div class="form-group">
                <label class="control-label" for="remetente">Remetente: </label>
                <?= Html::input('text', 'email[]', isset($remetente['email']) ? strtolower($remetente['email']) : '', ['id' => 'remetente', 'class' => 'form-control']); ?>
                <p class="help-block help-block-error"></p>
            </div>
        </td>
        <td>
            <div class="form-group">
                <label class="control-label" for="destinatario">Destinatário: </label>
                <?= Html::input('text', 'email[]', isset($destinatario['email']) ? strtolower($destinatario['email']) : '', ['id' => 'destinatario', 'class' => 'form-control']); ?>
                <p class="help-block help-block-error"></p>
            </div>
        </td>
        <td>
            <div class="form-group">
                <label class="control-label" for="consignatario">Consignatario: </label>
                <?= Html::input('text', 'email[]', isset($consignatario['email']) ? strtolower($consignatario['email']) : '', ['id' => 'consignatario', 'class' => 'form-control']); ?>
                <p class="help-block help-block-error"></p>
            </div>
        </td>
        <td>
            <div class="form-group">
                <label class="control-label" for="outros">Outros: </label>
                <?= Html::input('text', 'email[]', '', ['id' => 'outros', 'class' => 'form-control']); ?>
                <p class="help-block help-block-error"></p>
            </div>
        </td>
    </tr>
</table>
<table class="table table-hover">
    <tr>
        <td>
            <?= Html::button('Enviar', ['class' => 'btn btn-success', 'id' => 'enviar-email']) ?>
        </td>
    </tr>
</table>

<?= Html::endForm() ?>

<div id="aguarde">
    Aguarde enquanto a mensagem é enviada...
    <div class="progress progress-sm active">
        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 40px">
            <span class="sr-only">lkajsdfkljsdalkfj</span>l
        </div>
    </div>
</div>

<div id="retornoEnvio">
    <h4>
        <i></i>
    </h4>
</div>