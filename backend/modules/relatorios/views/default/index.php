<?php

use backend\assets\RelatoriosAsset;
use yii\helpers\Html;
use yii\helpers\Url;

RelatoriosAsset::register($this);
?>

<div class="relatorios-default-index">
    <p>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua-gradient">
            <div class="inner">
                <h3 id="countFaturas"><i class="fa fa-refresh fa-spin"></i></h3>

                <p>Faturas</p>
            </div>
            <div class="icon">
                <i class="fa fa-money"></i>
            </div>
            <?= Html::a('Gerar fatura<i class="fa fa-arrow-circle-right"></i>',
                Url::to('fatura'), ['class' => 'small-box-footer'])
            ?>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow-gradient">
            <div class="inner">
                <h3 id="countCte"><i class="fa fa-refresh fa-spin"></i></h3>

                <p>CT-e's</p>
            </div>
            <div class="icon">
                <i class="fa fa-file-code-o"></i>
            </div>
            <?= Html::a('Emitir CT-e <i class="fa fa-arrow-circle-right"></i>',
                Url::to('cte/default/create'), ['class' => 'small-box-footer'])
            ?>            
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green-gradient">
            <div class="inner">
                <h3 id="countMinutas"><i class="fa fa-refresh fa-spin"></i></h3>

                <p>Minutas</p>
            </div>
            <div class="icon">
                <i class="fa fa-newspaper-o"></i>
            </div>
            <?= Html::a('Emitir Mintuta <i class="fa fa-arrow-circle-right"></i>',
                Url::to('minutas/create'), ['class' => 'small-box-footer'])
            ?>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red-gradient">
            <div class="inner">
                <h3 id="countFrota"><i class="fa fa-refresh fa-spin"></i></h3>

                <p>Veículos</p>
            </div>
            <div class="icon">
                <i class="fa fa-truck"></i>
            </div>
            <?= Html::a('Adicionar veículo <i class="fa fa-arrow-circle-right"></i>',
                Url::to('veiculos/default/create'), ['class' => 'small-box-footer'])
            ?>
        </div>
    </div>
</p>
<p>
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green-gradient">
            <div class="inner">
                <h3 id="countReceber"><i class="fa fa-refresh fa-spin"></i></h3>

                <p>Receber</p>
            </div>
            <div class="icon">
                <i class="fa fa-dollar"></i>
            </div>
            <?= Html::a('Gerar relatório <i class="fa fa-arrow-circle-right"></i>',
                Url::to('relatorios/default/receber'), ['class' => 'small-box-footer'])
            ?>
        </div>
    </div>
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow-gradient">
            <div class="inner">
                <h3 id="countBalanco"><i class="fa fa-refresh fa-spin"></i></h3>

                <p>Balanço Financeiro</p>
            </div>
            <div class="icon">
                <i class="fa fa-bar-chart"></i>
            </div>
            <?= Html::a('Gerar relatório <i class="fa fa-arrow-circle-right"></i>',
                Url::to('relatorios/default/balanco'), ['class' => 'small-box-footer'])
            ?>
        </div>
    </div>
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red-gradient">
            <div class="inner">
                <h3 id="countPagar"><i class="fa fa-refresh fa-spin"></i></h3>

                <p>Pagar</p>
            </div>
            <div class="icon">
                <i class="fa fa-dollar"></i>
            </div>
            <?= Html::a('Gerar relatório <i class="fa fa-arrow-circle-right"></i>',
                Url::to('relatorios/default/pagar'), ['class' => 'small-box-footer'])
            ?>
        </div>
    </div>
</p>
</div>
