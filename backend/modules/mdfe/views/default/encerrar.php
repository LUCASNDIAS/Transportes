<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

use NFePHP\MDFe\Tools;

$cteTools = new Tools('D:\ambiente_desenvolvedor_php\www\Transportes\backend\config\config.json');

$aRetorno = array();

$resp = $cteTools->sefazEncerra(
        $chave = '31170609204054000143580010000000021000000107',
        $tpAmb = '2',
        $nSeqEvento = '1',
        $nProt = '931170000012286',
        $cUF = '31',
        $cMun = '3106200',
        $aRetorno
    );

echo '<pre>';
var_dump($resp);
echo '</pre>';

echo '<pre>';
var_dump($aRetorno);
echo '</pre>';