<?php

use yii\helpers\Html;
use backend\assets\ChartAsset;
use yii\db\Query;

/* @var $this yii\web\View */
ChartAsset::register($this);
$this->title = ''; //Yii::$app->params['sistemaNome'];
?>
<div class="site-index">

    <div class="col-md-12">
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-primary">
                <h3 class="widget-user-username"><?= Yii::$app->user->identity['nome'] ?></h3>
                <h5 class="widget-user-desc">-- <?= Yii::$app->user->identity['cnpj'] ?> --</h5>
            </div>
            <div class="widget-user-image">
                <?php echo Html::img(Yii::$app->user->identity['foto'], ['class' => 'img-circle']); ?>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <p>Use o menu ao para navegar pelo sistema e, caso tenha d&uacute;vidas ou sugest&otilde;es,
                            entre em contato pelo e-mail: <?= Yii::$app->params['supportEmail']; ?> ou pelo telefone:
                            <?= Yii::$app->params['adminTelefone']; ?>.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 border-right">
                        <div class="description-block">
                            <h3>CT-e</h3>
                            <span>
                                <?= Html::a('Buscar', '@web/cte', array('class' => 'btn btn-primary')); ?>
                                <?= Html::a('Emitir', '@web/cte/default/create', array('class' => 'btn btn-success')); ?>
                            </span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 border-right">
                        <div class="description-block">
                            <h3>Minutas</h3>
                            <span>
                                <?= Html::a('Buscar', '@web/minutas', array('class' => 'btn btn-primary')); ?>
                                <?= Html::a('Emitir', '@web/minutas/create', array('class' => 'btn btn-success')); ?>
                            </span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 border-right">
                        <div class="description-block">
                            <h3>MDF-e</h3>
                            <span>
                                <?= Html::a('Buscar', '@web/mdfe', array('class' => 'btn btn-primary')); ?>
                                <?= Html::a('Emitir', '@web/mdfe/default/create', array('class' => 'btn btn-success')); ?>
                            </span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3">
                        <div class="description-block">
                            <h3>Faturas</h3>
                            <span>
                                <?= Html::a('Minuta', '@web/fatura/default/create', array('class' => 'btn btn-success')); ?>
                                <?= Html::a('CT-e', '@web/minuta/default/create-cte', array('class' => 'btn btn-success')); ?>
                            </span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
        </div>
        <!-- /.widget-user -->
    </div>

    <div class="col-md-12" id="grafico">
        <!-- AREA CHART -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Balanço Financeiro</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" style="">
                <div class="chart">
                    <canvas id="areaChart" style="height: 250px; width: 512px;" width="512" height="250"></canvas>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
