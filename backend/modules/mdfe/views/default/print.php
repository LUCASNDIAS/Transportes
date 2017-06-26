<?php

use backend\assets\MdfePrintAsset;
use yii\helpers\Html;
use backend\commands\Basicos;

MdfePrintAsset::register($this);

$this->title = Yii::t('app', 'Minutas');
$basicos     = new Basicos();

?>

<div id="pos_topo">
    <table border="0">
        <tr>
            <td>
                <div id="pos_logo">
                    <?=
                    Html::img('@web/img/usuarios/Logo-'.Yii::$app->user->identity['cnpj'].'.jpg',
                        [
                        'width' => '150px'
                    ]);
                    ?>
                </div>
            </td>
            <td>
                <div id="pos_cabecalho">
                    <div class="titulo">Lóggica Cargas LTDA - ME</div>
                    <span class="t">CNPJ: </span> 09.204.054/0001-43
                    <span class="t mlg">IE: </span> 0010526120088
                    <span class="t mlg">RNTR: </span> <?= $model['rntrc']; ?>
                    <p>
                        <span class="t">Razão Social: </span> Lóggica Cargas LTDA - ME
                    </p>
                    <p>
                        <span class="t">Logradouro: </span> Rua Desembargador
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
            </td>
        </tr>
    </table>

</div>

<div id="pos_damdfe">
    <hr>
    <div>
        <span class="titulo mlp">DAMDFE</span>
        <span class="t mlg">Documento Auxiliar de Manifesto Eletrônico de Documentos Fiscais</span>
    </div>
</div>

<div id="pos_barras" class="center">
    <hr>
    <span class="t">CONTROLE DO FISCO</span>
</div>

<div id="pos_chave">
    <div class="t">CHAVE DE ACESSO</div>
    <div class="center"><?= $model['chave']; ?></div>
</div>

<div id="pos_protocolo">
    <div class="t">PROTOCOLO DE AUTORIZAÇÃO</div>
    <div class="center"><?= $model['protocolo']; ?></div>
</div>

<div id="pos_dados_mdfe">

    <div id="pos_modelo">
        <div class="t">Modelo</div>
        <div class="center">58</div>
    </div>

    <div id="pos_serie">
        <div class="t">Série</div>
        <div class="center">001</div>
    </div>

    <div id="pos_numero">
        <div class="t">Número</div>
        <div class="center"><?= $model['numero']; ?></div>
    </div>

    <div id="pos_fl">
        <div class="t">Folha</div>
        <div class="center">1 / 1</div>
    </div>

    <div id="pos_dthr">
        <div class="t">Data/Hora de Emissão</div>
        <div class="center"><?= $model['dtemissao']; ?></div>
    </div>

    <div id="pos_ufcarga">
        <div class="t">UF Carreg.</div>
        <div class="center"><?= $model['ufcarga']; ?></div>
    </div>

    <div id="pos_ufdescarga">
        <div class="t">UF Descarreg.</div>
        <div class="center"><?= $model['ufdescarga']; ?></div>
    </div>

</div>

<div id="pos_rodo">

    <div id="pos_rodo_tit">
        <div class="t">Modal Rodoviário de Carga</div>
    </div>

    <div id="pos_left">
        <div id="pos_cte">
            <div class="t">Qtd. CT-e</div>
            <div class="center"><?= $model['qtdecte']; ?></div>
        </div>

        <div id="pos_nfe">
            <div class="t">Qtd. NFe</div>
            <div class="center"><?= $model['qtdenfe']; ?></div>
        </div>

        <div id="pos_peso">
            <div class="t">Peso Total</div>
            <div class="center"><?= $model['pesomercadoria']; ?> Kg</div>
        </div>

        <div id="pos_veic_tit">
            Veículo 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="t">Placa: </span> <?= $model['placa']; ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="t">RNTRC: </span> <?= $model['rntrc']; ?>
        </div>

    </div>

    <div id="pos_right">

        <div id="pos_condutor">
            <span class="t">Condutores</span>
        </div>

        <div id="pos_condutor_cpf">
            <span class="t">CPF</span><br />
            <?php print_r($condutores[0]['condutor']); ?>
        </div>

        <div id="pos_condutor_nome">
            <span class="t">Nome</span><br />
            <?php print_r($condutores[0]['xnome']); ?>
        </div>
        
    </div>

</div>

<div id="pos_obs">
    <span class="t">Observações</span>
</div>

