<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\clientes\models\ClientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Clientes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Clientes'), ['create'],
            ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            //'id',
            //'cridt',
            //'criusu',
            //'dono',
            [
                'label' => 'Nome',
                'format' => 'ntext',
                'attribute' => 'nome',
                'value' => function($model) {
//                    $nome = explode(' ', $model->nome);
                    $nome = substr($model->nome, 0, 25);
                    return $nome;
                }
            ],
//            'nome',
            'cnpj',
//            [
//                'label' => 'Nomes',
//                'format' => 'ntext',
//                'attribute'=>'clientesContatos',
//                'value' => function($model) {
//                    foreach ($model->clientesContatos as $contatos) {
//                        $Nomes[] = $contatos->nome;
//                    }
//                    return isset($Nomes) ? implode("\n", $Nomes) : 'sem responsáveis';
//                },
//            ],
            // 'ie',
            // 'endrua',
            // 'endnro',
            // 'endbairro',
            'endcid',
            'enduf',
        // 'endcep',
        // 'status',
        ],
    ]);
    ?>
<?php Pjax::end(); ?>
</div>
