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

//return var_dump(Yii::getAlias('@backend/sped/') . 'config/' . Yii::$app->user->identity['cnpj'] . '.json');

$cteTools = new Tools(Yii::getAlias('@backend/sped/') . 'config/' . Yii::$app->user->identity['cnpj'] . '.json');

$dhEmi = $model->dtemissao;
$numeroCTE = $model->numero; //rand();
//
$chave = $model->chave;

$resp = $cte->taginfMDFe($chave, $versao = '1.00');

$cDV = substr($chave, -1);

$resp = $cte->tagide(
        $cUF = '31',
        $tpAmb = $model->ambiente,
        $tpEmit = $model->tipoemitente,
        $mod = '58',
        $serie = '1',
        $nMDF = $numeroCTE,
        $cMDF = '09835783',
        $cDV,
        $modal = $model->modalidade,
        str_replace(' ', 'T', $dhEmi),
        $tpEmis = $model->formaemissao,
        $procEmi = '0',
        $verProc = '2.0',
        $ufIni = $model->ufcarga,
        $ufFim = $model->ufdescarga
    );

foreach ($munCarga as $carrega) {
    $resp = $cte->tagInfMunCarrega(
        $cMunCarrega = $carrega['cMun'],
        $xMunCarrega = $carrega['xMun']
    );
}

foreach ($munPercurso as $percurso) {
    $resp = $cte->tagInfPercurso($ufPer = $percurso['uf']);
}

$resp = $cte->tagemit(
        $cnpj = $emitente['cnpj'],
        $numIE = $emitente['ie'],
        $xNome = $emitente['nome'],
        $xFant = $emitente['nome']
    );

$resp = $cte->tagenderEmit(
        $xLgr = $emitente['endrua'],
        $nro = $emitente['endnro'],
        $xCpl = '',
        $xBairro = $emitente['endbairro'],
        $cMun = '3106200',
        $xMun = 'Belo Horizonte',
        $cep = str_replace('-', '', $emitente['endcep']),
        $siglaUF = $emitente['enduf'],
        $fone = '31987796794',
        $email = 'loggica@hotmail.com'
    );

foreach ($munDescarga as $descarrega) {
$resp = $cte->tagInfMunDescarga(
        $nItem = 0,
        $cMunDescarga = $descarrega['cMun'],
        $xMunDescarga = $descarrega['xMun']
    );
}

foreach ($documentos as $documento) {
$resp = $cte->tagInfCTe(
        $nItem = 0,
        $chCTe = $documento['chave'],
        $segCodBarra = ''
    );
}

$resp = $cte->tagTot(
        $qCTe = $model->qtdecte,
        $qNFe = '',
        $qMDFe = '',
        $vCarga = $model->valormercadoria,
        $cUnid = $model->unidademedida,
        $qCarga = $model->pesomercadoria . '000'
    );

$resp = $cte->tagautXML(
        $cnpj = '',
        $cpf = '09835783624'
    );

$resp = $cte->taginfAdic(
        $infAdFisco = (empty($model->inffisco)) ? '' : $model->inffisco,
        $infCpl = (empty($model->infcontribuinte)) ? '' : $model->infcontribuinte
    );

$resp = $cte->tagInfModal($versaoModal = '1.00');

$resp = $cte->tagRodo(
        $rntrc = $model->rntrc,
        $ciot = ''
    );

foreach($condutores as $condutor) {
$resp = $cte->tagCondutor(
        $xNome = $condutor['xnome'],
        $cpf = $condutor['condutor']
    );
}

$resp = $cte->tagVeicTracao(
        $cInt = '', // Código Interno do Veículo
        $placa = $model->placa, // Placa do veículo
        $tara = '10000',
        $capKG = '500',
        $capM3 = '60',
        $tpRod = '06',
        $tpCar = '02',
        $UF = 'MG',
        $propRNTRC = ''
    );

$resp = $cte->montaMDFe();

$filename = "D:\ambiente_desenvolvedor_php\www\Transportes\backend\sped\mdfe\\{$chave}-mdfe.xml";

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
$tpAmb = $model->ambiente;
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
        $tpAmb = $model->ambiente,
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

