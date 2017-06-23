<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

use NFePHP\MDFe\Tools;

$cteTools = new Tools('D:\ambiente_desenvolvedor_php\www\Transportes\backend\config\config.json');

$chave = '31170609204054000143570010000000831000000101-mdfe';
$tpAmb = '1';
$filename = "D:\ambiente_desenvolvedor_php\www\Transportes\sped\mdfe\\{$chave}.xml";

if (! $cteTools->validarXml($filename) || sizeof($cteTools->errors)) {
    echo "<h3>Algum erro ocorreu.... </h3>";
    foreach ($cteTools->errors as $erro) {
        if (is_array($erro)) {
            foreach ($erro as $err) {
                echo "$err <br>";
            }
        } else {
            echo "$erro <br>";
        }
    }
} else {
    echo "MDF-e Válido!";
}
