<?php

use backend\assets\FaturaPrintAsset;
use yii\helpers\Html;
use backend\commands\Basicos;

FaturaPrintAsset::register($this);

$this->title = Yii::t('app', 'Faturas');
$basicos     = new Basicos();
?>


<div style="position: fixed; right: 0mm; bottom: 0mm; rotate: -90;">
    <barcode code="978-0-9542246-0" class="barcode" />
</div>


<div className="page-break">
    <div id="pos_topo">
        <table width="715px">
            <tr>
                <td width="30%">
                    <?php
                    echo Html::img('@web/img/usuarios/Logo-'.$empresa->cnpj.'.jpg',
                        [
                        'class' => 'img-circle',
                        'alt' => Yii::$app->user->identity ['empresa'],
                        'height' => '100px'
                    ]);
                    ?>
                </td>
                <td width="55%" style="text-align: center">
                    <b><?= $empresa->nome; ?></b><BR />
                    <?= ucwords(strtolower($empresa->endrua)).', '.$empresa->endnro.' - '.ucwords(strtolower($empresa->endbairro)); ?><br />
                    Cep: <?= $empresa->endcep; ?> - <?= ucwords(strtolower($empresa->endcid)); ?><br />
                    <?php // echo str_replace('|', ' / ', $empresa->telefones); ?>
                    <BR /> <?php // echo str_replace('|', '', $empresa->emails);          ?><br />
                    Insc. Estadual: <?= $empresa->ie; ?><br /> CNPJ: <?= $empresa->cnpj; ?>
                </td>
                <td width="15%" style="text-align:right">
                    <BR /> <span class="fontminuta" style="color: #FF0000;">FATURA</span><br />
                    <br /> <span class="fontnum"><?=
                        str_pad($model->numero, 6, '0', STR_PAD_LEFT);
                        ?></span><br />
                    <br />
                </td>
            </tr>
        </table>

    </div>

    <div id="pos_lateral" style="background-image: url('img/sistema/fundo.png');position:fixed;display:block;top:90px;left:5px;width:120px;height:383px;border:1px solid #000;font-size:11px;font-weight:bold;text-align:center;float:left;">
    </div>

    <div id="firstblock" style="position:fixed; display: inline;">

        <div id="pos_banco" style="position:absolute;display:block;border:1px solid #000;font-size:10px;font-weight:bold;width:130px;height:80px;text-align:center;float: right;"><br />BANCO</div>
        <div id="pos_dados_gerais" style="position:fixed;height:40px;width:394px;border:1px solid #000;font-size:12px;font-weight:bold; text-align: center; display: inline;">

            <table border="1">
                <tr>
                    <td width="25%"><div align="center">FATURA</div></td>
                    <td width="25%"><div align="center">EMISS&Atilde;O</div></td>
                    <td width="25%"><div align="center" id="linkvenc">VENCIMENTO</div></td>
                    <td width="25%"><div align="center">VALOR (R$) </div></td>
                </tr>
                <tr>
                    <td width="25%"><span align="center"><?=
                            str_pad($model->numero, 6, '0', STR_PAD_LEFT);
                            ?></span></td>
                    <td width="25%"><span align="center"><?=
                            $basicos->formataData('print', $model->emissao);
                            ?></span></td>
                    <td width="25%"><span align="center" id="posvenc" style="color:#FF0000"><?=
                            $basicos->formataData('print', $model->vencimento);
                            ?></span></td>
                    <td width="25%"><span align="center" id="posvalor"><?=
                            number_format($docs['total']['frete'], 2, ',', '.');
                            ?></span></td>
                </tr>
            </table>
        </div>

        <div id="pos_dados_comentario" style="position:absolute;top:135px;left:121px;display:block;height:40px;width:294px;border:1px solid #000;font-size:10px;font-weight:bold;">&nbsp;&nbsp;Observações: <span id="coment"><?= $model->observacoes ?></span>
        </div>


    </div>

    <div id="pos_dados_sacado">
        &nbsp;&nbsp;<span>Nome do Sacado:</span> <?= $sacado->nome; ?><br>
        &nbsp;&nbsp;CNPJ / CPF: <?= $sacado->cnpj; ?>&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I.E: <?= $sacado->ie; ?>
        <p>&nbsp;&nbsp;<span>Enderço:</span> <?= $sacado->endrua.', '.$sacado->endnro; ?></p>
        <p>&nbsp;&nbsp;<span>Bairro:</span> <?= $sacado->endbairro; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cidade: <?= $sacado->endcid; ?></p>
        <p>&nbsp;&nbsp;CEP: <?= $sacado->endcep; ?></p><br/>
        <p>&nbsp;&nbsp;Endereço de Cobrança: <?= $sacado->endrua.', '.$sacado->endnro; ?></p>



    </div>

    <!--<div id="pos_valor_ext">-->

    <div id="pos_valor_ext_tit">
        VALOR<BR>POR<BR>EXTENSO
    </div>

    <div id="pos_valor_ext_val">
        &nbsp;&nbsp;<?= $basicos->extenso($docs['total']['frete'], true); ?>
    </div>

    <!--</div>-->

    <div id="pos_orientacao">
        Reconheco(emos) a exatidão desta DUPLICADA DE PRESTA&Ccedil;&Atilde;O DE
        SERVI&Ccedil;O na importância acima que pagarei(emos) a
        <?= $empresa->nome; ?>, ou a sua ordem na pra&ccedil;a at&eacute;
        o vencimento acima indicado.
    </div>

    <!--<div id="pos_assinatura">-->

    <div id="pos_assinatura_data"><br>________/__________/_________<br>DATA DE ACEITE</div>

    <div id="pos_assinatura_ass"><BR>_______________________________________________<br>ASSINATURA DO SACADO</div>

    <!--</div>-->

    <!--    <div id="pos_lateral" style="background-image: url('../img/sistema/fundo.png');position:fixed;display:block;top:90px;left:5px;width:120px;height:383px;border:1px solid #000;font-size:11px;font-weight:bold;text-align:center;float:left;">
        </div>-->
    <!--</div>-->

    <div id="pos_tit">
        <span class="fontnum" id="linkembarques">Rela&ccedil;&atilde;o dos Embarques que compoem esta fatura:</span>
    </div>

    <div id="pos_dados">
        <table class="tbela">
            <thead>
                <tr style="background-color: #00733e">
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
        <table class="tbela">
            <tr>
                <td>TOTAIS ==></td>
                <td>Embarques: <?= $docs['total']['embarques']; ?></td>
                <td>R$ Notas: <?=
                    number_format($docs['total']['notasvalor'], 2, ',', '.');
                    ?></td>
                <td>Volumes: <?= $docs['total']['notasvolumes']; ?></td>
                <td>Peso (Kg): <?=
                    number_format($docs['total']['peso'], 2, ',', '.');
                    ?></td>
                <td>R$ Frete: <?=
                    number_format($docs['total']['frete'], 2, ',', '.');
                    ?></td>
            </tr>
        </table>
    </div>
</div>