 <?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Minutas */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Minuta',
]) . str_pad($model->numero, 6, '0', STR_PAD_LEFT);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Minutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="minutas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

