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

$cte = new Make();

$cteTools = new Tools('D:\ambiente_desenvolvedor_php\www\Transportes\backend\config\config.json');

$dhEmi = date("Y-m-d\TH:i:s");
$numeroCTE = 3; //rand();
//
$chave = $cte->montaChave(
    $cUF = '31',                // Codigo da UF da tabela do IBGE: 41-PR
    $ano = date('y', strtotime($dhEmi)),
    $mes = date('m', strtotime($dhEmi)),
    $cnpj = $cteTools->aConfig['cnpj'],
    $mod = '58',                // Modelo do documento fiscal: 57 para identificação do CT-e
    $serie = '1',               // Serie do CTe
    $numero = $numeroCTE,       // Numero do CTe
    $tpEmis = '1',              // Forma de emissao do CTe: 1-Normal; 4-EPEC pela SVC; 5-Contingência
    $cCT = '10'
);               // Codigo numerico que compoe a chave de acesso (Codigo aleatorio do emitente, para evitar acessos indevidos ao documento)

$resp = $cte->taginfMDFe($chave, $versao = '1.00');

$cDV = substr($chave, -1);

$resp = $cte->tagide(
        $cUF = '31',
        $tpAmb = '2',
        $tpEmit = '1',
        $mod = '58',
        $serie = '1',
        $nMDF = $numeroCTE,
        $cMDF = '00000010',
        $cDV,
        $modal = '1',
        $dhEmi,
        $tpEmis = '1',
        $procEmi = '0',
        $verProc = '2.0',
        $ufIni = 'MG',
        $ufFim = 'SC'
    );

$resp = $cte->tagInfMunCarrega(
        $cMunCarrega = '3106200',
        $xMunCarrega = 'Belo Horizonte'
    );

$resp = $cte->tagInfPercurso($ufPer = 'SP');
$resp = $cte->tagInfPercurso($ufPer = 'PR');

$resp = $cte->tagemit(
        $cnpj = '09204054000143',
        $numIE = '0010526120088',
        $xNome = 'LOGGICA CARGAS LTDA - ME',
        $xFant = 'LOGGICA CARGAS LTDA - ME'
    );

$resp = $cte->tagenderEmit(
        $xLgr = 'RUA DESEMBARG CONTINENTINO',
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

$resp = $cte->tagInfMunDescarga(
        $nItem = 0,
        $cMunDescarga = '4205407',
        $xMunDescarga = 'FLORIANOPOLIS'
    );

$resp = $cte->tagInfCTe(
        $nItem = 0,
        $chCTe = '31150109204054000143570010000009991301700568',
        $segCodBarra = ''
    );

$resp = $cte->tagTot(
        $qCTe = '1',
        $qNFe = '',
        $qMDFe = '',
        $vCarga = '350.00',
        $cUnid = '01',
        $qCarga = '200.0000'
    );

$resp = $cte->tagautXML(
        $cnpj = '',
        $cpf = '09835783624'
    );

$resp = $cte->taginfAdic(
        $infAdFisco = 'Qualquer coisa para o fisco.',
        $infCpl = 'Outra coisa do contribuinte'
    );

$resp = $cte->tagInfModal($versaoModal = '1.00');

$resp = $cte->tagRodo(
        $rntrc = '10167059',
        $ciot = ''
    );

$resp = $cte->tagCondutor(
        $xNome = 'GERSON PRATTI',
        $cpf = '53086465620'
    );

$resp = $cte->tagVeicTracao(
        $cInt = '100', // Código Interno do Veículo
        $placa = 'OQX7777', // Placa do veículo
        $tara = '5000',
        $capKG = '500',
        $capM3 = '60',
        $tpRod = '06',
        $tpCar = '02',
        $UF = 'MG',
        $propRNTRC = ''
    );

$resp = $cte->montaMDFe();
$filename = "D:\ambiente_desenvolvedor_php\www\Transportes\sped\mdfe\\{$chave}-mdfe.xml";

if ($resp) {
    //header('Content-type: text/xml; charset=UTF-8');
    $xml = $cte->getXML();
    file_put_contents($filename, $xml);
    //chmod($filename, 0777);
    //echo $xml;
} else {
    header('Content-type: text/html; charset=UTF-8');
    foreach ($cte->erros as $err) {
        echo 'tag: &lt;' . $err['tag'] . '&gt; ---- ' . $err['desc'] . '<br>';
    }
}

$xml = file_get_contents($filename);
$xml = $cteTools->assina($xml);

file_put_contents($filename, $xml);

$aRetorno = array();
$tpAmb = '2';
$idLote = '';
$indSinc = '1';
$flagZip = false;

$msg='';

if (! $cteTools->validarXml($filename) || sizeof($cteTools->errors)) {
    $msg .= "<h3>Algum erro ocorreu.... </h3>";
    foreach ($cteTools->errors as $erro) {
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

$retorno = $cteTools->sefazEnviaLote(
        $xml,
        $tpAmb = '2',
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
var_dump($chave);
echo '</pre>';

