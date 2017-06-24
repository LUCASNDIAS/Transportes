<?php

use NFePHP\MDFe\Tools;

// Arquivo de Configuração
$json = Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json';

// Instancia de Tools
$mdfeTools = new Tools($json);

// Variável com retorno da consulta
$aResposta = array();

// Sigla para pesquisa do Status
$siglaUF = $mdfeTools->aConfig['siglaUF'];

// Tipos de ambiente para verificar o status
$tpsAmb = [
    '1' => 'Produção',
    '2' => 'Homologação'
];

$status = array();

foreach ($tpsAmb as $tpAmb => $xtpAmb) {
    // Faz a consulta do Status
    $retorno = $mdfeTools->sefazStatus($siglaUF, $tpAmb, $aResposta);

    $status[$tpAmb] = [
            'Ambiente' => ($tpAmb == 1) ? 'Produção' : 'Homologação',
            'cStat' => $aResposta['cStat'],
            'xMotivo' => $aResposta['xMotivo'],
            'UF' => $siglaUF
        ];
}

return $status;
