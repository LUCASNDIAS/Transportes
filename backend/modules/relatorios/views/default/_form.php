<?php

use yii\helpers\Html;
use yii\jui\AutoComplete;
use backend\assets\RelatoriosFormAsset;

RelatoriosFormAsset::register($this);
?>
<div class="area-print">
    <div class="relatorios-form">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Informe o período</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Data inicial:</label>

                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control data" name="di" id="di">
                    </div>
                    <!-- /.input group -->
                </div>
                <!-- /.form group -->

                <div class="form-group">
                    <label>Data final:</label>

                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control data" name="df" id="df">
                    </div>
                    <!-- /.input group -->
                </div>
                <!-- /.form group -->

                <div class="row">
                    <div class="col-sm-12">
                        <input type="radio" name='status' value='TODOS' checked="checked"> Todos
                        <input type="radio" name='status' value='VENCER'> A vencer
                        <input type="radio" name='status' value='VENCIDO'> Vencido
                        <input type="radio" name='status' value='PAGO'> Pago/recebido
                    </div>
                </div>

                <input type="text" name="tipo" class="hidden" value="<?= $tp; ?>" id="tipo"/>

                <div class="row">
                    <div class="col-sm-2">
                        <?=
                        Html::submitButton('Gerar',
                            ['class' => 'btn btn-block btn-primary',
                                'id' => 'gerar'])
                        ?>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
        </div>

    </div>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Relatório Financeiro</h3>

            <div class="box-tools pull-right">
                <button id="imprimir" type="button" class="btn btn-box-tool" data-widget="print"><i
                            class="fa fa-print"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
            <div class="table-responsive">
                <table class="table no-margin">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Vencimento</th>
                        <th>Valor</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody id="resultados">
                    <!--                    <tr>-->
                    <!--                        <td><a href="pages/examples/invoice.html">Nome</a></td>-->
                    <!--                        <td>Descrição</td>-->
                    <!--                        <td>Vencimento</td>-->
                    <!--                        <td>Valor</td>-->
                    <!--                        <td><span class="label label-success">Status</span></td>-->
                    <!--                    </tr>-->
                    </tbody>
                </table>

                <table class="table no-margin">
                    <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                    </tr>
                    </thead>
                    <tbody id="resultados-totais">
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <!--    <div class="box-footer clearfix" style="">-->
        <!--        <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>-->
        <!--        <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>-->
        <!--    </div>-->
        <!-- /.box-footer -->
    </div>
</div>