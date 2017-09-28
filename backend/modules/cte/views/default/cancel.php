<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\cte\models\CteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Cancelar CT-e');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cte-cancel">
    <?php
    $form = ActiveForm::begin([
            'id' => 'cancel-form'
    ]);
    ?>

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

    <div class="col-sm-10">
        Justificativa: <?php echo Html::input('text', 'motivo', '',
        ['class' => 'form-control']);
    ?>
    </div>

    <div class="col-sm-2">
        <br /><?= Html::submitButton('Cancelar CT-e', ['class' => 'btn btn-danger']) ?>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <br><br>
            <p>
                <?php
                if (!empty($retorno)) {
                    if ($retorno['cStat'] != '135') {
                        echo $retorno['cStat'].' - '.$retorno['xMotivo'];
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
