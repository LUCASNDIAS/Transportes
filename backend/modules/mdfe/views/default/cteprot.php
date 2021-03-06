<?php
/* * @category  Teste
 * @package   Spedcteexamples
 * @copyright 2009-2016 NFePHP
 * @name      testaMakeCTe.php
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @link      http://github.com/nfephp-org/sped-cte for the canonical source repository
 * @author    Samuel M. Basso <samuelbasso@gmail.com>
 * Adaptado por Maison K. Sakamoto <maison.sakamoto@gmail.com>
 *
 * Teste para a versão 2.0 do CT-e
 * */

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

use NFePHP\CTe\Make;
use NFePHP\CTe\Tools;

$cte = new Make();

$files = [
    '31171011095658000140570010000003051032041485',
    '31171011095658000140570010000003061032048363',
    '31171011095658000140570010000003071098357833'
];

foreach ($files as $file) {

    $filename = '/var/www/html/Transportes/backend/sped/cte/'.$file.'.xml';
    $novo     = '/var/www/html/Transportes/backend/sped/cte/CTe'.$file.'.xml';

    $cteTools = new Tools(Yii::getAlias('@backend/sped/').'config/'.Yii::$app->user->identity['cnpj'].'.json');

    $xml = file_get_contents($filename);

    $aRetorno = array();
    $retorno  = $cteTools->sefazConsultaChave($file, '1', $aRetorno);

    $protocolo = '/var/www/html/Transportes/backend/sped/cte/11095658000140/producao/temporarias/201710/'.$file.'-retConsSitCTe.xml';

    $salvar = $cteTools->addProtocolo($filename, $protocolo);

    file_put_contents($novo, $salvar);


    echo '<pre>';
//    echo htmlspecialchars($cteTools->soapDebug);
    var_dump($salvar);
    echo "</pre>";

//    echo '<pre>';
//    var_dump($aRetorno);
//    echo '</pre>';
}

