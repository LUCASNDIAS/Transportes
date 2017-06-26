<?php

use backend\assets\MdfePrintAsset;
use yii\helpers\Html;
use backend\commands\Basicos;

MdfePrintAsset::register($this);

$this->title = Yii::t('app', 'Minutas');
$basicos     = new Basicos();
?>

<div id="pos_topo">
    <div id="pos_logo">
        <?=
        Html::img('@web/img/usuarios/Logo-'.Yii::$app->user->identity['cnpj'].'.jpg',
            [
            'width' => '150px'
        ]);
        ?>
    </div>

    <div id="pos_cabecalho">
        <div class="titulo">Lóggica Cargas LTDA - ME</div>
        <span class="t">CNPJ: </span> 09.204.054/0001-43
        <span class="t mlg">IE: </span> 0010526120088
        <span class="t mlg">RNTR: </span> 00000000
        <p>
            <span class="t">Razão Social: </span> 09.204.054/0001-43
        </p>
        <p>
            <span class="t">Logradouro: </span> 09.204.054/0001-43
            <span class="t mlg">Número: </span> 131
        </p>
        <p>
            <span class="t">Complemento: </span> 
            <span class="t mlg">Bairro: </span> Caiçaras
        </p>
        <p>
            <span class="t">UF: </span> MG
            <span class="t mlg">Município: </span> Belo Horizonte
            <span class="t mlg">CEP: </span> 30770-180
        </p>
    </div>
</div>

<div id="pos_damdfe">
    <div>
        <span class="titulo mlp">DAMDFE</span>
        <span class="t mlg">Documento Auxiliar de Manifesto Eletrônico de Documentos Fiscais</span>
    </div>
</div>

<div id="pos_barras" class="center">
    <span class="t">CONTROLE DO FISCO</span>
</div>

<div id="pos_chave">
    <div class="t">CHAVE DE ACESSO</div>
    <div class="center">3214.5467.8909.8765.4321.1234.5678.9098.7654.3212.1234</div>
</div>

<div id="pos_protocolo">
    <div class="t">PROTOCOLO DE AUTORIZAÇÃO</div>
    <div class="center">93229933889908</div>
</div>

<div id="pos_dados_mdfe">

    <div id="pos_modelo">
        <div class="t">Modelo</div>
        <div class="center">58</div>
    </div>

</div>

