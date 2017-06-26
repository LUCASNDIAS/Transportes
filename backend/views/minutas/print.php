<?php

use backend\assets\MinutasPrintAsset;
use yii\helpers\Html;
use backend\commands\Basicos;

MinutasPrintAsset::register($this);

$this->title = Yii::t('app', 'Minutas');
$basicos     = new Basicos();
?>

<div id="pos_topo">
    <table width="715px">
        <tr>
            <td width="38%">
                <?php
                echo Html::img('@web/img/usuarios/Logo-'.$empresa->cnpj.'.jpg',
                    [
                    'class' => 'img-circle',
                    'alt' => Yii::$app->user->identity ['empresa'],
                    'height' => '100px'
                ]);
                ?>
            </td>
            <td width="38%" style="text-align: center">
                <b><?= $empresa->nome; ?></b><BR />
                <?= ucwords(strtolower($empresa->endrua)).', '.$empresa->endnro.' - '.ucwords(strtolower($empresa->endbairro)); ?><br />
                Cep: <?= $empresa->endcep; ?> - <?= ucwords(strtolower($empresa->endcid)); ?><br />
<?= str_replace('|', ' / ', $empresa->telefones); ?>
                <BR /> <?= str_replace('|', '', $empresa->emails); ?><br />
                Insc. Estadual: <?= $empresa->ie; ?><br /> CNPJ: <?= $empresa->cnpj; ?>
            </td>
            <td width="24%" style="text-align:right">
                <BR /> <span class="fontminuta" style="color: #FF0000;">MINUTA</span><br />
                <br /> <span class="fontnum"><?= str_pad($model->numero, 6,
    '0', STR_PAD_LEFT); ?></span><br />
                <br />
            </td>
        </tr>
    </table>

</div>

<div id="pos_tfrete">

    <div class="centrotfrete">

        <span class="negrito" id="linktipofrete">Tipo de Frete:</span>
        <span id="tipofrete"><?= $model->tipofrete; ?></span>
        &nbsp;&nbsp;
        <span class="negrito" id="linklocalentrega">Local de entrega:</span>
        <span id="entregalocal"><?= $model->entregalocal; ?></span>
        &nbsp;&nbsp;
        <span class="negrito" id="linkqmpaga">Frete pago:</span>
        <span id="qmpaga"><?= $model->pagadorenvolvido; ?></span>
        &nbsp;&nbsp;
        <span class="negrito" id="linkpagamento">Forma de Pgto.:</span>
        <span id="formapagto"><?= $model->formapagamento; ?></span>

    </div>

</div>

<div id="pos_remetente">

    <div class="pos_titrd">

        <span class="negsub" id="linkremetente">REMETENTE</span>
        <p>
        <div class="margintop">
            <span class="negrito">Nome: </span> <?= $remetente->nome; ?>
        </div>
        <div class="margintop">
            <span class="negrito">CNPJ/CPF: </span> <?= $remetente->cnpj; ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="negrito">IE/RG: </span>
<?= $remetente->ie; ?>
        </div>
        <div class="margintop">
            <span class="negrito">Endere&ccedil;o: </span> <?= $remetente->endrua.', '.$remetente->endnro; ?>
        </div>
        <div class="margintop">
            <span class="negrito">Bairro: </span><?= $remetente->endbairro; ?>
            &nbsp;&nbsp;&nbsp;&nbsp; <span class="negrito">Fone: </span>
            <?php
            $remetenteTel      = explode('|', $remetente->telefones);
            echo $remetenteTel [0];
            ?>
        </div>
        <div class="margintop">
            <span class="negrito">Cidade: </span><?= $remetente->endcid; ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="negrito">Estado: </span>
<?= $remetente->enduf; ?>
        </div>
        </p>

    </div>

</div>

<div id="pos_destinatario">

    <div class="pos_titrd">

        <span class="negsub">DESTINAT&Aacute;RIO</span>
        <p>


        <div class="margintop">
            <span class="negrito">Nome: </span><?= $destinatario->nome; ?>
        </div>
        <div class="margintop">
            <span class="negrito">CNPJ/CPF: </span><?= $destinatario->cnpj; ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="negrito">IE/RG: </span>
<?= $destinatario->ie; ?>
        </div>
        <div class="margintop">
            <span class="negrito">Endere&ccedil;o: </span>
<?= $destinatario->endrua.', '.$destinatario->endnro; ?>
        </div>
        <div class="margintop">
            <span class="negrito">Bairro: </span><?= $destinatario->endbairro; ?>
            &nbsp;&nbsp;&nbsp;&nbsp; <span class="negrito">Fone: </span>
            <?php
            $destinatarioTel   = explode('|', $destinatario->telefones);
            echo $destinatarioTel [0];
            ?>
        </div>
        <div class="margintop">
            <span class="negrito">Cidade: </span><?= $destinatario->endcid; ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="negrito">Estado: </span>
<?= $destinatario->enduf; ?>
        </div>
        </p>

    </div>

</div>

<div id="pos_nf">

    <div class="centrotfrete">
        <span class="negrito" id="linknfnumero">N. Fiscal: </span>
        <span id="nfnumero"><?= str_replace("|", " ", $model->notasnumero); ?></span>
        &nbsp;&nbsp;&nbsp;
        <span class="negrito" id="linknfvalor">Valor: </span>
        <span id="nfvalor">
            <?php
            $valorNF           = explode('|', $model->notasvalor);
            echo array_sum($valorNF);
            ?>
        </span>
        &nbsp;&nbsp;&nbsp;
        <span class="negrito" id="linknfvolumes">Volumes: </span>
        <span id="nfvolumes">
            <?php
            $volumesNF         = explode('|', $model->notasvolumes);
            echo array_sum($volumesNF);
            ?>
        </span>
    </div>
</div>

</div>

<div id="pos_coleta">

    <div class="pos_titrd">

        <span class="negsub" id="linkcoleta">COLETA</span>
        <p>


        <div class="margintop">
            <span class="negrito">Data:</span> <span id="coldt">
                <?php
                $coletadata        = ($model->baixacoleta) ? $basicos->formataData('var',
                        $model->coletadata) : '';
                echo $coletadata;
                ?>
            </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span
                class="negrito">Hora:</span> <span id="colhr"><?= $model->coletahora; ?></span>
        </div>
        <div class="margintop">
            <span class="negrito">Func. que coletou:</span> <span id="colnome">
<?= $model->coletanome; ?></span>
        </div>
        <div class="margintop">
            <span class="negrito">Placa do ve&iacute;culo:</span> <span
                id="colplaca"><?= $model->coletaplaca; ?></span>
        </div>
        </p>
    </div>

</div>

<div id="pos_entrega">

    <div class="pos_titrd">

        <span class="negsub" id="linkentrega">ENTREGA</span>
        <p>


        <div class="margintop">
            <span class="negrito">Data:</span> <span id="entdt">
                <?php
                $entregadata       = ($model->baixaentrega) ? $basicos->formataData('var',
                        $model->entregadata) : '';
                echo $entregadata;
                ?>
            </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span
                class="negrito">Hora:</span> <span id="enthr"><?= $model->entregahora; ?></span>
        </div>
        <div class="margintop">
            <span class="negrito">Recebedor:</span> <span id="entnome"><?= $model->entreganome; ?></span>
        </div>
        <div class="margintop">
            <span class="negrito">Documento:</span> <span id="entdoc"><?= $model->entregadoc; ?></span>
        </div>
        <div class="margintop">
            <span class="negrito">Assinatura:</span> ___________________
        </div>
        </p>
    </div>

</div>

<div id="pos_consignatario">
    <div class="tnf1">
        <span class="negrito" id="linkconsignatario">Consignat&aacute;rio:</span>
        <span id="cons_nome">
<?php
$consignatarioNome = ($consignatario === null) ? ' ---- ' : $consignatario->nome;
echo $consignatarioNome;
?>
        </span>
    </div>
</div>

<div id="pos_cfrete">

    <div class="pos_titrd">

        <span class="negsub" id="linkcomfrete">COMPOSI&Ccedil;&Atilde;O DO
            FRETE</span>
        <p>
        <table>
            <tr>
                <td><span class="negrito">Frete peso:</span></td>
                <td style="text-align: right"><span id="fretepeso"><?= $model->fretepeso; ?></span></td>
            </tr>
            <tr>
                <td><span class="negrito">Frete valor:</span></td>
                <td style="text-align: right"><span id="valfreteper"><?= $model->fretevalor; ?></span></td>
            </tr>
            <tr>
                <td><span class="negrito">Taxas Extras:</span></td>
                <td style="text-align: right"><span id="txextra"><?= $model->taxaextra; ?></span></td>
            </tr>
            <tr>
                <td><span class="negrito"><font color="#ff0000;">Desconto:</font></span></td>
                <td style="text-align: right"><span id="txgris"><?= $model->desconto; ?></span></td>
            </tr>
            <tr>
                <td><span class="negrito" style="font-size: 13px; color: #0000FF">TOTAL:</span></td>
                <td style="text-align: right"><span id="fretetotal" style="font-size: 13px; color: #0000FF; font-weight: bold;"><?= $model->fretetotal; ?></span></td>
            </tr>
        </table>
        </p>

    </div>

    <div id="ddcfrete">

        <div class="margintop">

        </div>
        <div class="margintop">

        </div>
        <div class="margintop">

        </div>
        <div class="margintop">

        </div>
    </div>

</div>

<div id="pos_preal">
    <div class="pos_titrd">
        <span class="negrito" id="linkpesoreal">Peso Real:</span> <span
            id="pesoreal"><?= $model->pesoreal; ?></span>
        <div class="margintop">
            <span class="negrito">Cubado:</span> <span id="pesocubado"><?= $model->pesocubado; ?></span>
        </div>
    </div>
</div>

<div id="pos_dimensoes">
    <div class="pos_titrd">
        <span class="negrito" id="linkdimensoes">Dimens&otilde;es:</span>
        <div class="margintop">
            <span id="dimensoes">
<?php
$dimensoesNF       = explode('|', $model->notasdimensoes);
echo $dimensoesNF [1];
?>
            </span>
        </div>
    </div>
</div>

<div id="pos_obs">
    <div class="pos_titrd">
        <span class="negrito" id="linkobs">Observa&ccedil;&atilde;o:</span> <span
            id="obs"><?= $model->observacoes; ?></span>
    </div>
</div>

<div id="pos_nat">
    <div class="pos_titrd">
        <span class="negrito" id="linkcarganatureza">Natureza da Carga:</span>
        <span id="carganatureza"><?= $model->naturezacarga; ?></span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="negrito" id="linktabela"
              style="color: #FF0000; font-size: 11px;">TABELA:</span> <span
              class="negrito" id="nometabela"><?= $tabela->nome; ?></span>
    </div>
</div>

<div id="pos_recibos">

    <div class="centrotfrete">

        &nbsp;
        <span class="negrito" id="linkrecibo">Fatura:</span>
        <span id="pgrec"><?= $model->fatura; ?></span>
        &nbsp;&nbsp;&nbsp;
        <span class="negrito">Data:</span>
        &nbsp;&nbsp;&nbsp;
        <span class="negrito">Valor Fatura:</span>

    </div>

</div>
