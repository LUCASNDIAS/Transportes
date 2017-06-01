<?php

use backend\assets\MinutasAsset;
use yii\helpers\Html;
use backend\commands\Basicos;

MinutasAsset::register($this);

$this->title = Yii::t('app', 'Enviar Minuta ') . str_pad($model->numero, 6, 0, STR_PAD_LEFT);
$basicos = new Basicos();
?>

<?= Html::beginForm(['minutas/send', 'id' => $model->id], 'post', ['enctype' => 'multipart/form-data', 'name' => 'form-envio', 'id' => $model->id]) ?>

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
                <?= Html::input('text', 'email[]', isset($remetente[0]) ? strtolower($remetente[0]) : '', ['id' => 'remetente', 'class' => 'form-control']); ?>
                <p class="help-block help-block-error"></p>
            </div>
        </td>
        <td>
            <div class="form-group">
                <label class="control-label" for="destinatario">Destinatário: </label>
                <?= Html::input('text', 'email[]', isset($destinatario[0]) ? strtolower($destinatario[0]) : '', ['id' => 'destinatario', 'class' => 'form-control']); ?>
                <p class="help-block help-block-error"></p>
            </div>
        </td>
        <td>
            <div class="form-group">
                <label class="control-label" for="consignatario">Consignatario: </label>
                <?= Html::input('text', 'email[]', isset($consignatario[0]) ? strtolower($consignatario[0]) : '', ['id' => 'consignatario', 'class' => 'form-control']); ?>
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