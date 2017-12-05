<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

use NFePHP\MDFe\Tools;

$cteTools = new Tools('/var/www/html/Transportes/backend/sped/config/09204054000143.json');

$aRetorno = array();

$resp = $cteTools->sefazCancela(
        $chave = '31171109204054000143580010000000991098357834',
        $tpAmb = '1',
        $nSeqEvento = '1',
        $nProt = '931170012279280',
        $xJust = 'Cancelado pelo cliente.',
        $aRetorno
    );

echo '<pre>';
var_dump($resp);
echo '</pre>';

echo '<pre>';
var_dump($aRetorno);
echo '</pre>';