<?php

use yii\helpers\Html;
use yii\db\Query;
/* @var $this yii\web\View */

$this->title = 'LND Sistemas';
// var_dump(Yii::$app->user->identity->attributes['nome']);

?>
<div class="site-index">

    <div class="jumbotron">
        <h2>Update de Dados</h2>

        <p class="lead">Parte administrativa para alteração das tabelas antigas para os
         novos formatos.</p>

       <!-- <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p> -->
    </div>

    <div class="body-content">
   
           <div class="row">
            <div class="col-lg-6" align="center">
                <h2>Clientes</h2>

                <p>Alteração das tabelas antigas para novos formatos.<br />
                Lembrar de definir o CNPJ do dono, para que não haja problemas
                de acesso não permitido.</p>

                <p>
                <?= Html::a('Atualizar Clientes', '@web/update/clientes', array('class'=>'btn btn-default'));?>
                </p>
            </div>
            <div class="col-lg-6" align="center">
                <h2>Minutas</h2>

                <p>Novo formato de tabela para minutas. Deve-se fazer um cliente
                por vez para evitar problemas de acesso.</p>

                <p>
                <?= Html::a('Atualizar Minutas', '@web/update/minutas', array('class'=>'btn btn-default disabled'));?>
                </p>
            </div>
        </div>

    </div>
</div>
