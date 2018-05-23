<?php

use backend\assets\FaturaPrintAsset;
use yii\helpers\Html;
use backend\commands\Basicos;

FaturaPrintAsset::register($this);

$this->title = Yii::t('app', 'Faturas');
$basicos = new Basicos();
?>


<div style="position: fixed; right: 1mm; top: 32mm;">
    <barcode code="54321068" type="I25" height="0.66"/>
</div>


<div className="page-break">
    <div style="display:block;position:fixed;top:5px;left:5px;width:100%;height:80px;border:1px solid #000000;">
        <table width="715px">
            <tr>
                <td width="30%">
                    <?php
                    echo Html::img('@web/img/usuarios/Logo-' . $empresa->cnpj . '.jpg',
                        [
                            'class' => 'img-circle',
                            'alt' => Yii::$app->user->identity ['empresa'],
                            'height' => '100px'
                        ]);
                    ?>
                </td>
                <td width="55%" style="text-align: center">
                    <span style="font-weight: bold"><?= $empresa->nome; ?></span><BR/>
                    <?= ucwords(strtolower($empresa->endrua)) . ', ' . $empresa->endnro . ' - ' . ucwords(strtolower($empresa->endbairro)); ?>
                    <br/>
                    Cep: <?= $empresa->endcep; ?> - <?= ucwords(strtolower($empresa->endcid)); ?>
                    <?php // echo str_replace('|', ' / ', $empresa->telefones); ?>
                    <?php // echo str_replace('|', '', $empresa->emails);          ?><br/>
                    Insc. Estadual: <?= $empresa->ie; ?><br/> CNPJ: <?= $empresa->cnpj; ?>
                </td>
                <td width="15%" style="text-align:center">
                    <span class="fontminuta" style="color: #FF0000;font-weight: bold;">FATURA</span><br/>
                    <br/> <span class="fontnum" style="font-weight: bold;"><?=
                        str_pad($model->numero, 6, '0', STR_PAD_LEFT);
                        ?></span><br/>
                    <br/>
                </td>
            </tr>
        </table>

    </div>

    <div id="firstblock" style="position:fixed; display: inline;">

        <div id="pos_banco"
             style="position:absolute;display:block;border:1px solid #000;font-size:10px;font-weight:bold;width:140px;height:80px;text-align:center;float: right;">
            CONTROLE
        </div>
        <div id="pos_dados_gerais"
             style="position:fixed;height:40px;width:398px;border:1px solid #000;font-size:10px;font-weight:bold; text-align: center; display: inline;">

            <table>
                <tr>
                    <td width="100">
                        <div align="center">FATURA</div>
                    </td>
                    <td width="100">
                        <div align="center">EMISS&Atilde;O</div>
                    </td>
                    <td width="100">
                        <div align="center" id="linkvenc">VENCIMENTO</div>
                    </td>
                    <td width="100">
                        <div align="center">VALOR (R$)</div>
                    </td>
                </tr>
                <tr>
                    <td><span align="center"><?=
                            str_pad($model->numero, 6, '0', STR_PAD_LEFT);
                            ?></span></td>
                    <td><span align="center"><?=
                            $basicos->formataData('print', $model->emissao);
                            ?></span></td>
                    <td><span align="center" id="posvenc" style="color:#FF0000"><?=
                            $basicos->formataData('print', $model->vencimento);
                            ?></span></td>
                    <td><span align="center" id="posvalor"><?=
                            number_format($docs['total']['frete'], 2, ',', '.');
                            ?></span></td>
                </tr>
            </table>
        </div>

        <div id="pos_dados_comentario"
             style="position:absolute;top:135px;left:121px;display:block;height:40px;width:398px;border:1px solid #000;font-size:10px;font-weight:bold;">
            &nbsp;&nbsp;Observações: <span id="coment"><?= $model->observacoes ?></span>
        </div>


    </div>

    <div id="pos_dados_sacado"
         style="position:fixed;display:block;top:180px;left:159px;width:710px;height:150px;border:1px solid #000;font-size:12px;font-weight:bold;">
        &nbsp;&nbsp;<span>Nome do Sacado:</span> <?= $sacado->nome; ?><br>
        &nbsp;&nbsp;CNPJ / CPF: <?= $sacado->cnpj; ?>&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I.E: <?= $sacado->ie; ?>
        <p>&nbsp;&nbsp;<span>Enderço:</span> <?= $sacado->endrua . ', ' . $sacado->endnro; ?></p>
        <p>&nbsp;&nbsp;<span>Bairro:</span> <?= $sacado->endbairro; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cidade: <?= $sacado->endcid; ?></p>
        <p>&nbsp;&nbsp;CEP: <?= $sacado->endcep; ?></p>
        <p>&nbsp;&nbsp;Endereço de Cobrança: <?= $sacado->endrua . ', ' . $sacado->endnro; ?></p>

    </div>

    <!--<div id="pos_valor_ext">-->

    <div style="background-color:#000;position:fixed;float: left;display:block;top:333px;left:159px;width:100px;height:45px;border:1px solid #000;font-size:11px;font-weight:bold;text-align:center;color:#ffffff;border: 1px;">
        VALOR<BR>POR<BR>EXTENSO
    </div>

    <div style="position: fixed;display:block;top:333px;left:261px;width:578px;height:47px;border:1px solid #000;font-size:12px;font-weight:bold;text-align:left;">
        &nbsp;&nbsp;<?= $basicos->extenso($docs['total']['frete'], true); ?>
    </div>

    <!--</div>-->

    <div style="position:fixed;display:block;top:379px;left:159px;width:578px;height:45px;border:1px solid #000;font-size:11px;font-weight:bold;">
        Reconheco(emos) a exatidão desta DUPLICADA DE PRESTA&Ccedil;&Atilde;O DE
        SERVI&Ccedil;O na importância acima que pagarei(emos) a
        <?= $empresa->nome; ?>, ou a sua ordem na pra&ccedil;a at&eacute;
        o vencimento acima indicado.
    </div>

    <!--<div id="pos_assinatura">-->

    <div style="position:fixed;float: left;display:block;top:426px;left:159px;width:266px;height:45px;border:1px solid #000;font-size:11px;font-weight:bold;text-align:center;">
        <br>________/__________/_________<br>DATA DE ACEITE
    </div>

    <div style="position:fixed;display:block;top:426px;left:360px;width:410px;height:45px;border:1px solid #000;font-size:11px;font-weight:bold;text-align:center;">
        <BR>_______________________________________________<br>ASSINATURA DO SACADO
    </div>

    <!--</div>-->

    <!--    <div id="pos_lateral" style="background-image: url('../img/sistema/fundo.png');position:fixed;display:block;top:90px;left:5px;width:120px;height:383px;border:1px solid #000;font-size:11px;font-weight:bold;text-align:center;float:left;">
        </div>-->
    <!--</div>-->
    <br/>
    <div id="pos_tit">
        <span class="fontnum" id="linkembarques">Rela&ccedil;&atilde;o dos Embarques que compoem esta fatura:</span>
    </div>

    <div style="display:block;position:fixed;top:503px;left:5px;width:720px;border:0px solid #000000;">
        <table border="1" style="width:720px;text-align:center;font-weight:bold;font-size: 11px;border-color: #fff;">
            <thead>
            <tr style="background-color: #dde299">
                <td><?= $model->tipo; ?></td>
                <td>REMETENTE</td>
                <td>DESTINATARIO</td>
                <td>EMISSAO</td>
                <td>NOTAS</td>
                <td>VALOR NF</td>
                <td>PESO</td>
                <td>VOLUMES</td>
                <td>R$ FRETE</td>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($docs['embarques'] as $embarque) {
                ?>
                <tr style="background-color: #dfdfdf">
                    <td><?= $embarque['numero']; ?></td>
                    <td><?= $embarque['remetente']; ?></td>
                    <td><?= $embarque['destinatario']; ?></td>
                    <td><?= $embarque['emissao']; ?></td>
                    <td><?= $embarque['notasnumero']; ?></td>
                    <td><?= number_format($embarque['notasvalor'], 2, ',', '.'); ?></td>
                    <td><?= number_format($embarque['peso'], 2, ',', '.'); ?></td>
                    <td><?= $embarque['notasvolumes']; ?></td>
                    <td><?= number_format($embarque['fretetotal'], 2, ',', '.'); ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <br>
        <table border="1" style="border="1" style="width:720px;text-align:center;font-weight:bold;font-size: 11px;border-color: #fff;"">
            <thead>
            <tr>
                <td>Embarques</td>
                <td>R$ Notas</td>
                <td>Volumes (Qtde)</td>
                <td>Peso (Kg)</td>
                <td>R$ Frete</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= $docs['total']['embarques']; ?></td>
                <td><?=
                    number_format($docs['total']['notasvalor'], 2, ',', '.');
                    ?></td>
                <td><?= $docs['total']['notasvolumes']; ?></td>
                <td><?=
                    number_format($docs['total']['peso'], 2, ',', '.');
                    ?></td>
                <td><?=
                    number_format($docs['total']['frete'], 2, ',', '.');
                    ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>