<?php

use yii\helpers\Html;
use yii\jui\AutoComplete;
use backend\assets\RelatoriosAsset;

RelatoriosAsset::register($this);
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Relatório Financeiro</h3>

        <div class="box-tools pull-right">
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
                        <th>Order ID</th>
                        <th>Item</th>
                        <th>Status</th>
                        <th>Popularity</th>
                    </tr>
                </thead>
                <tbody id="resultados">
                    <tr>
                        <td><a href="pages/examples/invoice.html">OR9842</a></td>
                        <td>Call of Duty IV</td>
                        <td><span class="label label-success">Shipped</span></td>
                        <td>
                            <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas style="display: inline-block; width: 34px; height: 20px; vertical-align: top;" width="34" height="20"></canvas></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix" style="">
        <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
        <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
    </div>
    <!-- /.box-footer -->
</div>