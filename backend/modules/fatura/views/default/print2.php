<?php

use backend\assets\FaturaPrintAsset;
use yii\helpers\Html;
use backend\commands\Basicos;

FaturaPrintAsset::register($this);

$this->title = Yii::t('app', 'Faturas');
$basicos     = new Basicos();
set_time_limit(0);
?>

<div style="position: fixed; right: -7mm; top: 12mm; rotate: -90;">
    <barcode code="9-00000-123456" class="barcode" size="0.8" height="0.5"/>
</div>

<div style="position: fixed; right: 0mm; top: 0mm;">
    <small><span class="text-red" style="margin-left: 50px;">Vencimento: 20/02/2018</span></small>
</div>

<div class="wrapper" style="position: absolute; top: 10mm; left: 15mm;" className="page-break">

    <!-- Main content -->
    <!--<section class="invoice">-->
    <!-- title row -->
    <div class="row">
        <div class="col-xs-11 well well-sm">
            <h5>
                <?php
                echo Html::img('@web/img/usuarios/Logo-'.$empresa->cnpj.'.jpg',
                    [
//                        'class' => 'img-circle',
                    'alt' => Yii::$app->user->identity ['empresa'],
                    'height' => '35px'
                ]);
                ?>
                <span>Elias Transportes Rápidos<span>
                        </h5>
                        </div>
                        <!-- /.col -->
                        </div>
                        <div class="row margin-top-small">
                            <div class="col-xs-5 well well-sm no-shadow text-muted">
                                <p>
                                    <span class="text-blue">Cedente:</span>
                                    <!--<address>-->
                                    <strong style="font-weight: bold;">Elias Transportes Rápidos</strong><br>
                                    795 Folsom Ave, Suite 600<br>
                                    San Francisco, CA 94107<br>
                                    Phone: (804) 123-5432<br>
                                    Email: info@almasaeedstudio.com
                                    <!--</address>-->
                                </p>
                            </div>
                            <div class="col-xs-5 well well-sm no-shadow text-muted">
                                <p>
                                    <span class="text-red">Sacado:</span>
                                    <!--<address>-->
                                    <strong style="font-weight: bold;">Elias Transportes Rápidos</strong><br>
                                    795 Folsom Ave, Suite 600<br>
                                    San Francisco, CA 94107<br>
                                    Phone: (804) 123-5432<br>
                                    Email: info@almasaeedstudio.com
                                    <!--</address>-->
                                </p>
                            </div>
                        </div>

                        <div class="row margin-top-small">
                            <div class="col-xs-2 well well-sm no-shadow text-muted">
                                <p>
                                    <span class="text-blue">Fatura</span><br>
                                    <!--<address>-->
                                    <strong style="font-weight: bold;">000154</strong>
                                    <!--</address>-->
                                </p>
                            </div>
                            <div class="col-xs-2 well well-sm no-shadow text-muted">
                                <p>
                                    <span class="text-blue">Emissão</span><br>
                                    <!--<address>-->
                                    <strong style="font-weight: bold;">01/01/2018</strong>
                                    <!--</address>-->
                                </p>
                            </div>
                            <div class="col-xs-3 well well-sm no-shadow text-muted">
                                <p>
                                    <span class="text-red">Vencimento</span><br>
                                    <!--<address>-->
                                    <strong style="font-weight: bold;">10/03/2018</strong>
                                    <!--</address>-->
                                </p>
                            </div>
                            <div class="col-xs-3 well well-sm no-shadow text-muted">
                                <p>
                                    <span class="text-blue">Valor (R$)</span><br>
                                    <!--<address>-->
                                    <strong style="font-weight: bold;">1.980,00</strong>
                                    <!--</address>-->
                                </p>
                            </div>
                        </div>
                        <div class="row margin-top-small">
                            <div class="col-xs-11 well well-sm text-muted">
                                <p>
                                    <span class="text-blue text-left" style="text-align: left">Valor por extenso: </span>
                                    <span style="font-weight: bold;">
                                        Mil e qualquer coisa e mais um tanto de reais e um pouco de centavos quebrando a linha para
                                        ver o valor quando br
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="row margin-top-small">
                            <div class="col-xs-11 well well-sm text-muted text-center">
                                <p>
                                    <span style="font-weight: bold;">
                                        Reconheço(emos) a exatidão desta DUPLICADA DE PRESTAÇÃO DE SERVIÇO na
                                        importância acima que pagarei(emos) a ELIAS TRANSPORTES RAPIDOS, ou a sua ordem
                                        na praça até o vencimento acima indicado
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="row margin-top-small">
                            <div class="col-xs-4 well well-small text-muted text-center">
                                <p>
                                    <span style="font-weight: bold;">
                                        _________/___________/_______________<br>
                                        Data do aceite
                                    </span>
                                </p>
                            </div>
                            <div class="col-xs-6 well well-small text-muted text-center no-shadow">
                                <p>
                                    <span style="font-weight: bold;">
                                        _____________________________________________________<br>
                                        Assinatura do Sacado
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="row margin-top-small">
                            <div class="col-xs-11 well well-sm text-muted text-center">
                                <p>
                                    <span style="font-weight: bold;">
                                        Relação dos Embarques que compoem esta fatura:
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-xs-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <div class="row" className="page-break">
                            <div class="col-xs-11 table-responsive">
                                <table class="table-striped text-center">
                                    <thead style="width: 20px;">
                                        <tr style="background-color: #00733e; height: 40px;">
                                            <th><?= $model->tipo; ?></th>
                                            <th width="12%">Remetente</th>
                                            <th width="12%">Destinatário</th>
                                            <th width="12">Emissão</th>
                                            <th width="20%">Notas</th>
                                            <th width="15%">R$ NF</th>
                                            <th width="10%">Peso</th>
                                            <th>Vol</th>
                                            <th width="10%">R$ Frete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($docs['embarques'] as $embarque) {
                                            $remetente    = explode(' ',
                                                $embarque['remetente']);
                                            $destinatario = explode(' ',
                                                $embarque['destinatario']);
                                            ?>
                                            <tr style="background-color: #dfdfdf">
                                                <td><?= $embarque['numero']; ?></td>
                                                <td><?= $remetente[0]; ?></td>
                                                <td><?= $destinatario[0]; ?></td>
                                                <td><?= $embarque['emissao']; ?></td>
                                                <td><?= $embarque['notasnumero']; ?></td>
                                                <td><?=
                                                    number_format($embarque['notasvalor'],
                                                        2, ',', '.');
                                                    ?></td>
                                                <td><?=
                                                    number_format($embarque['peso'],
                                                        2, ',', '.');
                                                    ?></td>
                                                <td><?= $embarque['notasvolumes']; ?></td>
                                                <td><?=
                                                    number_format($embarque['fretetotal'],
                                                        2, ',', '.');
                                                    ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                            <?php for($i=0;$i<34;$i++) {
                                                ?>

                                            <tr style="background-color: #dfdfdf">
                                                <td>afsd</td>
                                                <td>f</td>
                                                <td>fasd</td>
                                                <td>fdf</td>
                                                <td>wt345</td>
                                                <td>dfs</td>
                                                <td>2345</td>
                                                <td>52sdf</td>
                                                <td>345fsd</td>
                                            </tr>
                                            <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row" className="page-break">
                            <div class="col-xs-11 table-responsive">
                                <table class="table-striped text-center" style="width: 700px;">
                                    <thead>
                                        <tr>
                                            <th width="20%">Embarques</th>
                                            <th width="20%">R$ Notas</th>
                                            <th width="20%">Volumes</th>
                                            <th width="20%">Peso (Kg)</th>
                                            <th width="20%">R$ Frete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= $docs['total']['embarques']; ?></td>
                                            <td><?=
                                                number_format($docs['total']['notasvalor'],
                                                    2, ',', '.');
                                                ?></td>
                                            <td><?= $docs['total']['notasvolumes']; ?></td>
                                            <td><?=
                                                number_format($docs['total']['peso'],
                                                    2, ',', '.');
                                                ?></td>
                                            <td><?=
                                                number_format($docs['total']['frete'],
                                                    2, ',', '.');
                                                ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>


                        </div>