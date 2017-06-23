<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

use NFePHP\MDFe\Tools;

$cteTools = new Tools('D:\ambiente_desenvolvedor_php\www\Transportes\backend\config\config.json');

$aRetorno = array();

$resp = $cteTools->sefazCancela(
        $chave = '31170609204054000143580010000000031000000104',
        $tpAmb = '2',
        $nSeqEvento = '1',
        $nProt = '931170000012288',
        $xJust = 'Cancelado pelo cliente.',
        $aRetorno
    );

echo '<pre>';
var_dump($resp);
echo '</pre>';

echo '<pre>';
var_dump($aRetorno);
echo '</pre>';