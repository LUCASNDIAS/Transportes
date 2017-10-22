<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\FaturaAsset;
use yii\jui\AutoComplete;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\fatura\models\Fatura */
/* @var $form yii\widgets\ActiveForm */

//FaturaAsset::register($this);
?>

<?php Pjax::begin(); ?>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn'],
        'id',
        'remetente',
        'destinatario',
        'consignatario',
        'notasnumero',
        'fretevalor',
        ['class' => 'yii\grid\ActionColumn',],
    ],
]);
?>
<?php Pjax::end(); ?>
                