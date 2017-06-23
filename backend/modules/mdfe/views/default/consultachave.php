<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

use NFePHP\MDFe\Tools;

$cteTools = new Tools('D:\ambiente_desenvolvedor_php\www\Transportes\backend\config\config.json');

$aRetorno = array();

$resp = $cteTools->sefazConsultaChave(
        $chave = '31170609204054000143580010000000031000000104',
        $tpAmb = '2',
        $aRetorno
    );

//echo '<pre>';
//print_r($resp);
//echo htmlspecialchars($cteTools->soapDebug);
//echo '</pre>';

echo '<pre>';
var_dump($aRetorno);
echo '</pre>';

