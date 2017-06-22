<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use NFePHP\MDFe\Tools;

$cteTools = new Tools('D:\ambiente_desenvolvedor_php\www\Transportes\backend\config\config.json');

//if(is_file('D:\ambiente_desenvolvedor_php\www\Transportes\backend\config\config.json')) {
//    echo "ok";
//} else {
//    echo 'erro';
//}

$aResposta = array();
$siglaUF = 'MG';
$tpAmb = '2';
$retorno = $cteTools->sefazStatus($siglaUF, $tpAmb, $aResposta);
echo '<pre>';
//echo htmlspecialchars($cteTools->soapDebug);
print_r($aResposta);
echo "</pre>";
