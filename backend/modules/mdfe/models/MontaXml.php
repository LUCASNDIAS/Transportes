<?php

namespace backend\modules\mdfe\models;

use NFePHP\MDFe\Make;
use NFePHP\MDFe\Tools;
use backend\modules\mdfe\models\Mdfe;
use backend\modules\clientes\models\Clientes;
use backend\modules\mdfe\models\MdfeCondutor as Condutor;
use backend\modules\mdfe\models\MdfeCarregamento as Carregamento;
use backend\modules\mdfe\models\MdfeDescarregamento as Descarregamento;
use backend\modules\mdfe\models\MdfeDocumentos as Documentos;
use backend\modules\mdfe\models\MdfePercurso as Percurso;
use Yii;

class MontaXml
{

    public function montarXml($id)
    {
        $model       = Mdfe::findOne($id);
        $emitente    = Clientes::findOne(['cnpj' => Yii::$app->user->identity['cnpj']]);
        $condutores  = Condutor::findAll(['mdfe_id' => $id]);
        $munCarga    = Carregamento::findAll(['mdfe_id' => $id]);
        $munDescarga = Descarregamento::findAll(['mdfe_id' => $id]);
        $documentos  = Documentos::findAll(['mdfe_id' => $id]);
        $munPercurso = Percurso::findAll(['mdfe_id' => $id]);

        $mdfe = new Make();

        $dhEmi     = $model->dtemissao;
        $numeroCTE = $model->numero;

        $chave = $model->chave;

        $resp   = $mdfe->taginfMDFe($chave, $versao = '1.00');

        $cDV = substr($chave, -1);

        $resp    = $mdfe->tagide(
            $cUF     = '31', $tpAmb   = $model->ambiente,
            $tpEmit  = $model->tipoemitente, $mod     = '58', $serie   = '1',
            $nMDF    = $numeroCTE, $cMDF    = '09835783', $cDV,
            $modal   = $model->modalidade, str_replace(' ', 'T', $dhEmi),
            $tpEmis  = $model->formaemissao, $procEmi = '0', $verProc = '2.0',
            $ufIni   = $model->ufcarga, $ufFim   = $model->ufdescarga
        );

        foreach ($munCarga as $carrega) {
            $resp        = $mdfe->tagInfMunCarrega(
                $cMunCarrega = $carrega['cMun'], $xMunCarrega = $carrega['xMun']
            );
        }

        foreach ($munPercurso as $percurso) {
            $resp  = $mdfe->tagInfPercurso($ufPer = $percurso['uf']);
        }

        $resp  = $mdfe->tagemit(
            $cnpj  = $emitente['cnpj'], $numIE = $emitente['ie'],
            $xNome = $emitente['nome'], $xFant = $emitente['nome']
        );

        $resp    = $mdfe->tagenderEmit(
            $xLgr    = $emitente['endrua'], $nro     = $emitente['endnro'],
            $xCpl    = '', $xBairro = $emitente['endbairro'], $cMun    = '3106200',
            $xMun    = 'Belo Horizonte',
            $cep     = str_replace('-', '', $emitente['endcep']),
            $siglaUF = $emitente['enduf'], $fone    = '31987796794',
            $email   = 'loggica@hotmail.com'
        );

        foreach ($munDescarga as $descarrega) {
            $resp         = $mdfe->tagInfMunDescarga(
                $nItem        = 0, $cMunDescarga = $descarrega['cMun'],
                $xMunDescarga = $descarrega['xMun']
            );
        }

        foreach ($documentos as $documento) {
            $resp        = $mdfe->tagInfCTe(
                $nItem       = 0, $chCTe       = $documento['chave'],
                $segCodBarra = ''
            );
        }

        $resp   = $mdfe->tagTot(
            $qCTe   = $model->qtdecte, $qNFe   = '', $qMDFe  = '',
            $vCarga = $model->valormercadoria, $cUnid  = $model->unidademedida,
            $qCarga = $model->pesomercadoria.'000'
        );

//        $resp = $mdfe->tagautXML(
//            $cnpj = '', $cpf  = '09835783624'
//        );

        $resp       = $mdfe->taginfAdic(
            $infAdFisco = (empty($model->inffisco)) ? '' : $model->inffisco,
            $infCpl     = (empty($model->infcontribuinte)) ? '' : $model->infcontribuinte
        );

        $resp        = $mdfe->tagInfModal($versaoModal = '1.00');

        $resp  = $mdfe->tagRodo(
            $rntrc = $model->rntrc, $ciot  = ''
        );

        foreach ($condutores as $condutor) {
            $resp  = $mdfe->tagCondutor(
                $xNome = $condutor['xnome'], $cpf   = $condutor['condutor']
            );
        }

        $resp      = $mdfe->tagVeicTracao(
            $cInt      = '', // Código Interno do Veículo
            $placa     = $model->placa, // Placa do veículo
            $tara      = '10000', $capKG     = '500', $capM3     = '60',
            $tpRod     = '06', $tpCar     = '02', $UF        = 'MG',
            $propRNTRC = ''
        );

        $resp = $mdfe->montaMDFe();

        if ($resp) {
            $xAmbiente = ($model->ambiente == 1) ? 'producao' : 'homologacao';
            $path      = \Yii::getAlias('@mdfe').'/'.$xAmbiente.'/temporarias/'.$chave.'.xml';
            $dir       = \Yii::getAlias('@mdfe').'/'.$xAmbiente.'/assinadas/'.$chave.'-mdfe.xml';
            $xml       = $mdfe->getXML();
            if ($this->salvaXml($xml, $path)) {
                $this->assinaXml($path, $dir);
                unlink($path);
                return $dir;
            }
        } else {
            return $mdfe->erros;
        }
    }

    public function salvaXml($xml, $path)
    {
        if (file_put_contents($path, $xml)) {
            return true;
        }
    }

    public function assinaXml($filename, $dir)
    {
        $mdfeTools = new Tools(Yii::getAlias('@backend/sped/').'config/'.Yii::$app->user->identity['cnpj'].'.json');

        $xml = file_get_contents($filename);
        $xml = $mdfeTools->assina($xml);

        file_put_contents($dir, $xml);
        return true;
    }

    public function validaXml($file)
    {
        $mdfeTools = new Tools(Yii::getAlias('@backend/sped/').'config/'.Yii::$app->user->identity['cnpj'].'.json');

        if (!$mdfeTools->validarXml($file)) {
            return $mdfeTools->errors;
        } else {
            return true;
        }
    }

    public function enviaXml($file, $tpAmb)
    {
        $mdfeTools = new Tools(Yii::getAlias('@backend/sped/').'config/'.Yii::$app->user->identity['cnpj'].'.json');

        $aRetorno = array();
        $idLote   = '';
        $indSinc  = '1';
        $flagZip  = false;

        $retorno = $mdfeTools->sefazEnviaLote(
            $file, $tpAmb, $idLote, $aRetorno
        );

        if (!empty($aRetorno)) {
            return $this->consultaProtocolo($aRetorno);
        }

        return 'Não houve resposta. Confira o Debug.';
    }

    public function consultaProtocolo($aRetorno)
    {
        $mdfeTools = new Tools(Yii::getAlias('@backend/sped/').'config/'.Yii::$app->user->identity['cnpj'].'.json');

        $aResposta = array();
        $recibo    = $aRetorno['nRec'];
        $tpAmb     = $aRetorno['tpAmb'];
        $retorno   = $mdfeTools->sefazConsultaRecibo($recibo, $tpAmb, $aResposta);

        return $aResposta;
    }
}