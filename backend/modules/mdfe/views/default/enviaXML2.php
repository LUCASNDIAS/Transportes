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

use NFePHP\MDFe\Make;
use NFePHP\MDFe\Tools;
use NFePHP\DA\MDFe\Damdfe;

$cte = new Make();

//return var_dump(Yii::getAlias('@backend/sped/') . 'config/' . Yii::$app->user->identity['cnpj'] . '.json');

$cteTools = new Tools(Yii::getAlias('@sped/') . 'config/' . Yii::$app->user->identity['cnpj'] . '.json');

$chave = '31171209204054000143580010000001011098357838';

$filename = "/var/www/html/{$chave}-mdfe.xml";
//
//$xml = file_get_contents($filename);
//$xml = $cteTools->assina($xml);
//
//file_put_contents($filename, $xml);
//
//$aRetorno = array();
//$tpAmb = '1';
//$idLote = '';
//$indSinc = '1';
//$flagZip = false;
//
//$msg='';
//
////if (! $cteTools->validarXml($filename) || sizeof($cteTools->errors)) {
////    $msg .= "<h3>Algum erro ocorreu.... </h3>";
////    foreach ($cteTools->errors as $erro) {
////        if (is_array($erro)) {
////            foreach ($erro as $err) {
////                $msg .= "$err <br>";
////            }
////        } else {
////            $msg .= "$erro <br>";
////        }
////    }
////    throw new Exception($msg,0);
////}
//
//$retorno = $cteTools->sefazEnviaLote(
//        $xml,
//        $tpAmb = '1',
//        $idLote = '',
//        $aRetorno
//    );
//
//$aResposta = array();
//$recibo = $aRetorno['nRec'];
//$retorno = $cteTools->sefazConsultaRecibo($recibo, $tpAmb, $aResposta);
////
//echo '<pre>';
//echo htmlspecialchars($cteTools->soapDebug);
//print_r($aResposta);
//echo "</pre>";
//
//echo '<pre>';
//var_dump($aRetorno);
//var_dump($chave);
//echo '</pre>';



// Xml file
        $xmlfile = file_get_contents($filename);

        // PDF
        $pdf = Yii::getAlias('@cte/').$chave.'-mdfe.pdf';

        $configFile = Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json';
        $configData = file_get_contents($configFile);
        $config     = json_decode($configData, true);
        $logo       = $config['aDocFormat']['pathLogoFile'];

        $dacte = new Damdfe($xmlfile, 'P', 'A4', $logo);
        $id    = $dacte->buildMDFe();
        $salva = $dacte->printMDFe($pdf, 'F');

