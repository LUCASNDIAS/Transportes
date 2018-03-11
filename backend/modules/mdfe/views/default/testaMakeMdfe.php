<?php
/**@category  Teste
 * @package   Spedmdfeexamples
 * @copyright 2009-2016 NFePHP
 * @name      testaMakedfe.php
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @link      http://github.com/nfephp-org/sped-cte for the canonical source repository
 * @author    Lucas Dias <diasnlucas@gmail.com>
 *
 * Teste para a versão 3.0 do Mdf-e
 **/

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

use NFePHP\MDFe\Make;
use NFePHP\MDFe\Tools;

$mdfe = new Make();
$mdfeTools = new Tools(Yii::getAlias('@sped/') . 'config/' . Yii::$app->user->identity['cnpj'] . '.json');

$dhEmi = '2018-03-06T17:50:00-02:00';
$numeroMDFe = 114; //rand(0,3345678);

$cUF = '31';
$ano = '18';
$mes = '03';
$cnpj = '09204054000143';
$mod = '58';
$serie = '1';
$numero = $numeroMDFe;
$tpEmis = '1';
$codigo = '09835783';

$chave = $mdfe->montaChave($cUF, $ano, $mes, $cnpj, $mod, $serie, $numero, $tpEmis, $codigo);

$resp = $mdfe->taginfMDFe($chave, $versao = '3.00');

$cDV = substr($chave, -1);

$resp = $mdfe->tagide(
        $cUF = '31',
        $tpAmb = '1',
        $tpEmit = '1',
        $tpTransp = '1',
        $mod,
        $serie,
        $nMDF = $numeroMDFe,
        $cMDF = $codigo,
        $cDV,
        $modal = '1',
        $dhEmi,
        $tpEmis,
        $procEmi = '0',
        $verProc = '2.0',
        $ufIni = 'MG',
        $ufFim = 'PE',
        $dhIniViagem = ''
    );

$resp = $mdfe->tagInfMunCarrega(
    $cMunCarrega = '3144805',
    $xMunCarrega = 'NOVA LIMA'
);

$resp = $mdfe->tagInfPercurso($ufPer = 'BA');
$resp = $mdfe->tagInfPercurso($ufPer = 'SE');
$resp = $mdfe->tagInfPercurso($ufPer = 'AL');


$resp = $mdfe->tagemit(
        $cnpj = '09204054000143',
        $numIE = '0010526120088',
        $xNome = 'LOGGICA CARGAS LTDA - ME',
        $xFant = 'LOGGICA CARGAS'
    );

$resp = $mdfe->tagenderEmit(
        $xLgr = 'R. DESEMBARG CONTINENTINO',
        $nro = '131',
        $xCpl = '',
        $xBairro = 'CAICARAS',
        $cMun = '3106200',
        $xMun = 'Belo Horizonte',
        $cep = '30770180',
        $siglaUF = 'MG',
        $fone = '31987796794',
        $email = 'loggica@hotmail.com'
    );

$resp = $mdfe->tagInfMunDescarga(
        $nItem = 0,
        $cMunDescarga = '2611606',
        $xMunDescarga = 'RECIFE'
    );

$resp = $mdfe->tagInfCTe(
        $nItem = 0,
        $chCTe = '31180309204054000143570010000024211098357835',
        $segCodBarra = ''
    );

//$resp = $mdfe->tagInfCTe(
//        $nItem = 0,
//        $chCTe = '31180109204054000143570010000022281098357838',
//        $segCodBarra = ''
//    );

$resp = $mdfe->tagSeg(
        $nApol = '5400005280',
        $nAver = $numeroMDFe
    );

$resp = $mdfe->tagInfResp(
        $respSeg = '1',
        $CNPJ = '',
        $CPF = ''
    );

$resp = $mdfe->tagInfSeg(
        $xSeg = 'SOMPRO',
        $CNPJ = '61383493000180'
    );

$resp = $mdfe->tagSeg(
        $nApol = '5500002659',
        $nAver = $numeroMDFe
    );

$resp = $mdfe->tagInfResp(
        $respSeg = '1',
        $CNPJ = '',
        $CPF = ''
    );

$resp = $mdfe->tagInfSeg(
        $xSeg = 'SOMPRO',
        $CNPJ = '61383493000180'
    );

$resp = $mdfe->tagTot(
        $qCTe = '1',
        $qNFe = '',
        $qMDFe = '',
        $vCarga = '300000.00',
        $cUnid = '01',
        $qCarga = '440.0000'
    );

$resp = $mdfe->tagautXML(
        $cnpj = '',
        $cpf = '09835783624'
    );

$resp = $mdfe->taginfAdic(
        $infAdFisco = 'Entrega em Patos de Minas',
        $infCpl = 'Sem detalhes'
    );

$resp = $mdfe->tagInfModal($versaoModal = '3.00');

$resp = $mdfe->tagRodo(
        $rntrc = '10167059'
    );

$resp = $mdfe->tagInfContratante(
        $CPF = '',
        $CNPJ = '71256283000185'
    );

$resp = $mdfe->tagCondutor(
        $xNome = 'EDER JOÃO ALVES DE SIQUEIRA',
        $cpf = '98005782691'
    );

$resp = $mdfe->tagVeicTracao(
        $cInt = '', // Código Interno do Veículo
        $placa = 'OWZ7777', // Placa do veículo
        $tara = '10000',
        $capKG = '500',
        $capM3 = '60',
        $tpRod = '06',
        $tpCar = '02',
        $UF = 'MG',
        $propRNTRC = ''
    );

$resp = $mdfe->montaMDFe();

$filename = "/var/www/html/{$chave}-mdfe.xml";

if ($resp) {
    //header('Content-type: text/xml; charset=UTF-8');
    $xml = $mdfe->getXML();
    file_put_contents($filename, $xml);
    //chmod($filename, 0777);
    //echo $xml;
} else {
    header('Content-type: text/html; charset=UTF-8');
    foreach ($mdfe->erros as $err) {
        echo 'tag: &lt;' . $err['tag'] . '&gt; ---- ' . $err['desc'] . '<br>';
    }
}


$xml = file_get_contents($filename);
$xml = $mdfeTools->assina($xml);

file_put_contents($filename, $xml);

$aRetorno = array();
$tpAmb = '1';
$idLote = '';
$indSinc = '1';
$flagZip = false;

$msg='';
//
if (! $mdfeTools->validarXml($filename) || sizeof($mdfeTools->errors)) {
    $msg .= "<h3>Algum erro ocorreu.... </h3>";
    foreach ($mdfeTools->errors as $erro) {
        if (is_array($erro)) {
            foreach ($erro as $err) {
                $msg .= "$err <br>";
            }
        } else {
            $msg .= "$erro <br>";
        }
    }
    throw new Exception($msg,0);
}
//
$retorno = $mdfeTools->sefazEnviaLote(
        $xml,
        $tpAmb,
        $idLote = '',
        $aRetorno
    );

$aResposta = array();
$recibo = $aRetorno['nRec'];
$retorno = $mdfeTools->sefazConsultaRecibo($recibo, $tpAmb, $aResposta);
//
echo '<pre>';
echo htmlspecialchars($mdfeTools->soapDebug);
print_r($aResposta);
echo "</pre>";

echo '<pre>';
var_dump($aRetorno);
var_dump($chave);
echo '</pre>';