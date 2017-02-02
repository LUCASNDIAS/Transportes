<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'LND Sistemas';
// var_dump(Yii::$app->user->identity->attributes['nome']);

?>
<div class="site-index">

    <div class="jumbotron">
        <h2><?php //$this->params['DadosUsuario']['nome']; ?></h2>

        <p class="lead">Use o menu ao para navegar pelo sistema e, caso tenha d&uacute;vidas ou sugest&otilde;es,
entre em contato pelo e-mail: diasnlucas@gmail.com
ou pelo telefone: (31)98779-6794.</p>

       <!-- <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p> -->
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4" align="center">
                <h2>CT-e</h2>

                <p>Emita e Conhecimentos de Transporte Eletr&ocirc;nico.</p>

                <p>
                <?= Html::a('Buscar', '@web/cte/listar', array('class'=>'btn btn-default'));?>
                <?= Html::a('Emitir', '@web/cte/novo', array('class'=>'btn btn-default'));?>
                </p>
            </div>
            <div class="col-lg-4" align="center">
                <h2>Minutas</h2>

                <p>Emita minutas rapidamente.</p>

                <p>
                <?= Html::a('Buscar', '@web/minuta/listar', array('class'=>'btn btn-default'));?>
                <?= Html::a('Emitir', '@web/minuta/novo', array('class'=>'btn btn-default'));?>
                </p>
            </div>
            <div class="col-lg-4" align="center">
                <h2>Faturas</h2>

                <p>Gere faturas e emita boletos.</p>

                <p>
                <?= Html::a('Minuta', '@web/fatura/novo/minuta', array('class'=>'btn btn-default'));?>
                <?= Html::a('CT-e', '@web/minuta/novo/cte', array('class'=>'btn btn-default'));?>
                </p>
            </div>
        </div>

    </div>
</div>
