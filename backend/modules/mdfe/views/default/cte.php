<?php
/**@category  Teste
 * @package   Spedcteexamples
 * @copyright 2009-2016 NFePHP
 * @name      testaMakeCTe.php
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @link      http://github.com/nfephp-org/sped-cte for the canonical source repository
 * @author    Samuel M. Basso <samuelbasso@gmail.com>
 * Adaptado por Maison K. Sakamoto <maison.sakamoto@gmail.com>
 *
 * Teste para a versão 2.0 do CT-e
 **/
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

use NFePHP\CTe\Make;
use NFePHP\CTe\Tools;

$cte = new Make();

$filename = '/var/www/html/Transportes/backend/sped/cte/31170911095658000140570010000002801072018270.xml';

//return var_dump(Yii::getAlias('@backend/sped/') . 'config/' . Yii::$app->user->identity['cnpj'] . '.json');

$cteTools = new Tools(Yii::getAlias('@backend/sped/') . 'config/' . Yii::$app->user->identity['cnpj'] . '.json');

$xml = file_get_contents($filename);
//$xml = $cteTools->assina($xml);
//
//file_put_contents($filename, $xml);

$retorno = $cteTools->sefazEnvia(
        $xml,
        $tpAmb = '1',
        $idLote = '',
        $aRetorno
    );

$aResposta = array();
$recibo = $aRetorno['nRec'];
$retorno = $cteTools->sefazConsultaRecibo($recibo, $tpAmb, $aResposta);
//
echo '<pre>';
echo htmlspecialchars($cteTools->soapDebug);
print_r($aResposta);
echo "</pre>";

echo '<pre>';
var_dump($aRetorno);
//var_dump($chave);
echo '</pre>';

