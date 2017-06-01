<?php

use yii\helpers\Html;
use yii\db\Query;
/* @var $this yii\web\View */

$this->title = 'LND Sistemas';
?>
<div class="site-index">

    <div class="jumbotron">
        <h2><?= Yii::$app->user->identity['nome']?></h2>

        <p class="lead">Use o menu ao para navegar pelo sistema e, caso tenha d&uacute;vidas ou sugest&otilde;es,
entre em contato pelo e-mail: <?= Yii::$app->params['supportEmail']; ?> ou pelo telefone: 
<?= Yii::$app->params['adminTelefone']; ?>.</p>

       <!-- <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p> -->
    </div>

    <div class="body-content">
   
           <div class="row">
            <div class="col-lg-4" align="center">
                <h2>CT-e</h2>

                <p>Emita e Conhecimentos de Transporte Eletr&ocirc;nico.</p>

                <p>
                <?= Html::a('Buscar', '@web/cte', array('class'=>'btn btn-default'));?>
                <?= Html::a('Emitir', '@web/cte/create', array('class'=>'btn btn-default'));?>
                </p>
            </div>
            <div class="col-lg-4" align="center">
                <h2>Minutas</h2>

                <p>Emita minutas rapidamente.</p>

                <p>
                <?= Html::a('Buscar', '@web/minutas', array('class'=>'btn btn-default'));?>
                <?= Html::a('Emitir', '@web/minutas/create', array('class'=>'btn btn-default'));?>
                </p>
            </div>
            <div class="col-lg-4" align="center">
                <h2>Faturas</h2>

                <p>Gere faturas e emita boletos.</p>

                <p>
                <?= Html::a('Minuta', '@web/fatura/create/minuta', array('class'=>'btn btn-default'));?>
                <?= Html::a('CT-e', '@web/minuta/create/cte', array('class'=>'btn btn-default'));?>
                </p>
            </div>
        </div>

    </div>
</div>
