<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'LND Sistemas';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>LND Sistemas</h1>

        <p class="lead">Seja bem vindo ao novo mundo da adminisração de Transportadoras.</p>

        <p>
        <?php 
        echo Html::a('Acesso ao Sistema', Yii::$app->urlManagerBackend->createUrl('site/login'), ['class' => 'btn btn-lg btn-success']);
        ?>
        <!--
         <a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a>
         -->
        
        </p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Controle sua frota</h2>

                <p>Nosso sistema de controle de frota é o mais completo. Aqui, você pode
                adicionar veículos e verificar as manutenções necessárias. Enviamos informações
                diárias sobre o status de cada veículo para que as revisões / reparos
                possam ser feitos.</p>

                <p>
	                <?php 
			        echo Html::a('Conheça nossos planos', Yii::$app->urlManager->createUrl('site/planos'), ['class' => 'btn btn-default']);
			        ?>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Emita documentos Fiscais</h2>

                <p>Emissões de CT-e e MDF-e! Conhecimentos e Manifestos já são obrigatórios.
                Utilize nossa ferramenta e emita de forma rápida, segura e o melhor:
                sem limites de emissões mensais.
                </p>

                <p>
	                <?php 
			        echo Html::a('Conheça nossos planos',Yii::$app->urlManager->createUrl('site/planos'), ['class' => 'btn btn-default']);
			        ?>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Gerencie sua empresa</h2>

                <p>Com os diversos tipos de relatórios fornecidos pelo sistema, você tem
                total controle do que está acontecendo na sua empresa: qual foi o melhor 
                período de vendas, quais os maiores gastos da empresa, entre muitos outros!</p>

                <p>
	                <?php 
			        echo Html::a('Conheça nossos planos', Yii::$app->urlManager->createUrl('site/planos'), ['class' => 'btn btn-default']);
			        ?>
                </p>
            </div>
        </div>

    </div>
</div>
