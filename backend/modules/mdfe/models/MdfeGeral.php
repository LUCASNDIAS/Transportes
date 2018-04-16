<?php

namespace backend\modules\mdfe\models;

use backend\modules\mdfe\models\Mdfe;
use backend\modules\clientes\models\Clientes;
use backend\models\Municipios;
use backend\modules\seguro\models\Seguro;
use backend\modules\mdfe\models\MdfeProtocolo;
use yii\web\Response;
use NFePHP\MDFe\Make;
use NFePHP\MDFe\Tools;
use NFePHP\DA\MDFe\Damdfe;
use Yii;

class MdfeGeral
{

    public function gerarXml($id)
    {
        // Model do Manifesto
        $model = $this->findModel($id);

        // Instancia p/ criar xml
        $mdfe      = new Make();
        $mdfeTools = new Tools(Yii::getAlias('@sped/').'config/'.Yii::$app->user->identity['cnpj'].'.json');

        // Pesquisas relacionadas aos clientes
        $cliente = new Clientes();

        // Pesquisas relacionadas aos Municípios (IBGE)
        $municipio = new Municipios();

        // Remover caracteres inválidos
        $invalidos = array("(", ")", "-", ".");

        $dhEmi      = str_replace(' ', 'T', $model->dtemissao);
        $dhEmi      .= date('P');
        $numeroMDFe = $model->numero;

        $chave = $model->chave;

        $resp   = $mdfe->taginfMDFe($chave, $versao = '3.00');

        $cDV = substr($chave, -1);

        $resp        = $mdfe->tagide(
            $cUF         = $mdfeTools->aConfig['cUF'],
            $tpAmb       = $model->ambiente, $tpEmit      = $model->tipoemitente,
            $tpTransp    = '1', $mod         = $model->modelo,
            $serie       = $model->serie, $nMDF        = $numeroMDFe,
            $cMDF        = '09835783', $cDV, $modal       = $model->modalidade,
            $dhEmi, $tpEmis      = $model->formaemissao, $procEmi     = '0',
            $verProc     = '2.0', $ufIni       = $model->ufcarga,
            $ufFim       = $model->ufdescarga, $dhIniViagem = ''
        );

        $carregamentos = $model->mdfeCarregamentos;

        foreach ($carregamentos as $cidade) {
            $resp        = $mdfe->tagInfMunCarrega(
                $cMunCarrega = $cidade->cMun, $xMunCarrega = $cidade->xMun
            );
        }

        $percursos = $model->mdfePercursos;

        foreach ($percursos as $percurso) {
            $resp  = $mdfe->tagInfPercurso(
                $ufPer = $percurso->uf
            );
        }

        // Informações do EMITENTE
        // Endereço do Emitente
        $emitente = $cliente::find()
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            ->andWhere(['cnpj' => $mdfeTools->aConfig['cnpj']])
            ->one();

        // Codigo do Municipio do Emitente
        $munemitente = $municipio::find()
            ->where(['municipio' => $emitente->endcid])
            ->andWhere(['uf' => $emitente->enduf])
            ->one();

        $resp  = $mdfe->tagemit(
            $cnpj  = $mdfeTools->aConfig['cnpj'], $numIE = $emitente->ie,
            $xNome = $mdfeTools->aConfig['razaosocial'],
            $xFant = $mdfeTools->aConfig['nomefantasia']
        );

        $resp    = $mdfe->tagenderEmit(
            $xLgr    = $emitente->endrua, // Logradouro
            $nro     = '0'.$emitente->endnro, // Numero
            $xCpl    = '', $xBairro = $emitente->endbairro, // Bairro
            $cMun    = $munemitente->codigo, // Código do município (utilizar a tabela do IBGE)
            $xMun    = $emitente->endcid, // Nome do municipio
            $cep     = str_replace($invalidos, '', $emitente->endcep), // CEP
            $siglaUF = $emitente->enduf, // Sigla UF
            $fone    = (isset($emitente->clientesContatos[0]->telefone)) ? str_replace($invalidos,
                '', $emitente->clientesContatos[0]->telefone) : '', // Fone
            $email   = ''
        );

        $descarregamentos = $model->mdfeDescarregamentos;

        foreach ($descarregamentos as $descarregamento) {
            $resp         = $mdfe->tagInfMunDescarga(
                $nItem        = 0, $cMunDescarga = $descarregamento->cMun,
                $xMunDescarga = $descarregamento->xMun
            );
        }

        $documentos = $model->mdfeDocumentos;

        foreach ($documentos as $documento) {
            if ($documento->tipo == 'CTE') {
                $resp        = $mdfe->tagInfCTe(
                    $nItem       = 0, $chCTe       = $documento->chave,
                    $segCodBarra = ''
                );
            }
            $contratantes[] = $documento->contratante;
        }

        $seguros = Seguro::findAll(['dono' => Yii::$app->user->identity['cnpj']]);

        foreach ($seguros as $seguro) {
            $resp  = $mdfe->tagSeg(
                $nApol = $seguro->napol, $nAver = 'Av' . $numeroMDFe
            );

            $resp    = $mdfe->tagInfResp(
                $respSeg = '1', $CNPJ    = '', $CPF     = ''
            );

            $resp = $mdfe->tagInfSeg(
                $xSeg = $seguro->xseg, $CNPJ = $seguro->cnpj
            );
        }

        $resp   = $mdfe->tagTot(
            $qCTe   = $model->qtdecte, $qNFe   = '', $qMDFe  = '',
            $vCarga = number_format($model->valormercadoria, 2, '.', ''), $cUnid  = $model->unidademedida,
            $qCarga = number_format($model->pesomercadoria, 4, '.', '')
        );

        $resp = $mdfe->tagautXML(
            $cnpj = '', $cpf  = '09835783624'
        );

        $resp       = $mdfe->taginfAdic(
            $infAdFisco = $model->inffisco, $infCpl     = $model->infcontribuinte
        );

        $resp        = $mdfe->tagInfModal($versaoModal = '3.00');

        $resp  = $mdfe->tagRodo(
            $rntrc = Yii::$app->user->identity['rntrc']
        );

        foreach (array_unique($contratantes) as $contratante) {
            $resp = $mdfe->tagInfContratante(
                $CPF  = (strlen($contratante) == 11) ? $contratante : '',
                $CNPJ = (strlen($contratante) == 14) ? $contratante : ''
            );
        }

        foreach ($model->mdfeCondutors as $condutor) {
            $resp  = $mdfe->tagCondutor(
                $xNome = $condutor->xnome, $cpf   = $condutor->condutor
            );
        }

        $resp      = $mdfe->tagVeicTracao(
            $cInt      = '', // Código Interno do Veículo
            $placa     = $model->placa, // Placa do veículo
            $tara      = '10000', $capKG     = '1500', $capM3     = '60',
            $tpRod     = '06', $tpCar     = '02', $UF        = 'MG',
            $propRNTRC = ''
        );

        // Monta o Manifesto
        $resp = $mdfe->montaMDFe();

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        // Nome do Arquivo
        $filename = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/geradas/'.$model->chave.'-mdfe.xml';

        // Verifica se houve erro ao montar o arquivo
        if ($resp) {
            $xml = $mdfe->getXML();
            file_put_contents($filename, $xml);
//            chmod($filename, 0777);

            $retorno = [
                'status' => true,
                'filename' => $filename,
                'erros' => [],
            ];
        } else {

            foreach ($mdfe->erros as $err) {
                $erro[] = 'tag: &lt;'.$err['tag'].'&gt; ---- '.$err['desc'].'<br>';
            }
            $retorno = [
                'status' => false,
                'filename' => '',
                'erros' => (isset($erro)) ? $erro : ['Erro não identificado']
            ];
        }

        return $retorno;
    }

    public function assinarXml($id)
    {
        $model = $this->findModel($id);

        $mdfeTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        // Arquivo a ser assinado
        $filename = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/geradas/'.$model->chave.'-mdfe.xml';

        // Assina o arquivo e cria outro na pasta assinadas
        $assinado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/assinadas/'.$model->chave.'-mdfe.xml';

        // Conteúdo do arquivo
        $xml = file_get_contents($filename);

        // Assina o documento
        $xml = $mdfeTools->assina($xml);
        file_put_contents($assinado, $xml);
//        chmod($assinado, 0777);

        $retorno = [
            'status' => true,
            'filename' => $assinado,
            'erros' => []
        ];

        return $retorno;
    }

    public function validarXml($id)
    {
        $model = $this->findModel($id);

        $mdfeTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        // Arquivo assinado
        $assinado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/assinadas/'.$model->chave.'-mdfe.xml';

        // Valida o arquivo e move para a pasta de validadas
        $validado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/validadas/'.$model->chave.'-mdfe.xml';

        // Mensagem de possíveis erros
        $msg = [];

        // Executa a validação do arquivo
        if (!$mdfeTools->validarXml($assinado) || sizeof($mdfeTools->errors)) {
            $msg[] = "<h3>Algum erro ocorreu.... </h3>";
            foreach ($mdfeTools->errors as $erro) {
                if (is_array($erro)) {
                    foreach ($erro as $err) {
                        $msg[] = "$err <br>";
                    }
                } else {
                    $msg[] = "$erro <br>";
                }
            }

            //chmod($validado, 0777);

            $retorno = [
                'status' => false,
                'filename' => '',
                'erros' => $msg
            ];
        } else {

            $retorno = [
                'status' => true,
                'filename' => (copy($assinado, $validado)) ? $validado : 'Não foi possível copiar o arquivo.',
                'erros' => []
            ];
        }

        return $retorno;
    }

    public function enviarXml($id)
    {
        $model = $this->findModel($id);

        $mdfeTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        // Arquivo Validado
        $validado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/validadas/'.$model->chave.'-mdfe.xml';

        // Verifica se o arquivo existe
        if (!is_file($validado)) {
            $retorno = [
                'status' => false,
                'filename' => $validado,
                'erros' => ['Arquivo não encontrado.']
            ];

            return $retorno;
        }

        //chmod($validado, 0777);
        $xml = file_get_contents($validado);

        // Define as variáveis para envio
        $aRetorno = array();
        $tpAmb    = $model->ambiente;
        $idLote   = '';
        $indSinc  = '1';
        $flagZip  = false;

        // Envia o arquivo para a sefaz
        $retorno = $mdfeTools->sefazEnviaLote(
            $xml, $tpAmb, $idLote  = '', $aRetorno
        );

        return $aRetorno;
    }

    public function reciboXml($id, $recibo)
    {
        $model     = $this->findModel($id);
        $tpAmb     = $model->ambiente;
        $aResposta = array();

        $mdfeTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Verifica o status pelo recibo
        $retorno = $mdfeTools->sefazConsultaRecibo($recibo, $tpAmb, $aResposta);

        // Salva os dados da consulta
        if (!empty($aResposta['aProt'])) {
            if ($aResposta['aProt']['cStat'] == '100') {
                $this->salvaProtocoloBD($id, $aResposta['aProt']);
            }
        }

        return $aResposta;
    }

    protected function salvaProtocoloBD($id, $protocolo)
    {
        $model = new MdfeProtocolo();

        $model->mdfe_id = $id;
        $model->dhrec   = str_replace('T', ' ', $protocolo['dhRecbto']);
        $model->nprot   = $protocolo['nProt'];
        $model->digval  = $protocolo['digVal'];
        $model->cstat   = $protocolo['cStat'];
        $model->xmotivo = $protocolo['xMotivo'];

        $model->save(false);

        return true;
    }

    public function protocoloXml($id, $recibo)
    {
        $model = $this->findModel($id);

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        $mdfeTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Arquivo Validado
        $validado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/validadas/'.$model->chave.'-mdfe.xml';

        // Protocolo
        $protocolo = Yii::getAlias('@mdfe/').$pamb.'/temporarias/'.date('Y').date('m').'/'.$recibo.'-retConsReciMDFe.xml';

        //return $protocolo;
        // Autorizado
        $autorizado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/enviadas/aprovadas/'.$model->chave.'-mdfe.xml';

        if (!is_file($protocolo)) {
            $retorno = [
                'status' => false,
                'filename' => $protocolo,
                'erros' => ['Protocolo não localizado.']
            ];
        } else {
            $salvar = $mdfeTools->addProtocolo($validado, $protocolo, true);
            file_put_contents($autorizado, $salvar);

            $retorno = [
                'status' => true,
                'filename' => $autorizado,
                'erros' => []
            ];

            // Altera o status do MDFe para Autorizado
            $model->status = "AUTORIZADO";

            $model->save();
        }

        return $retorno;
    }

    public function gerarPdf($id)
    {
        $model = $this->findModel($id);

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        $mdfeTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        if ($model->status === 'CANCELADO') {
            // Cancelado
            $autorizado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/canceladas/'.$model->chave.'-mdfe.xml';
        } else if ($model->status === 'AUTORIZADO') {
            // Autorizado
            $autorizado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/enviadas/aprovadas/'.$model->chave.'-mdfe.xml';
        } else {
            // Assina o arquivo e cria outro na pasta assinadas
            $autorizado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/assinadas/'.$model->chave.'-mdfe.xml';

            if (!is_file($autorizado)) {
                $autorizado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/geradas/'.$model->chave.'-mdfe.xml';
            }

            $enviado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/enviadas/aprovadas/'.$model->chave.'-mdfe.xml';

            if (is_file($enviado)) {
                $autorizado = $enviado;
            }
        }

        // Gera o xml
        if (!is_file($autorizado)) {
            $this->gerarXml($id);
        }

        // Xml file
        $xmlfile = file_get_contents($autorizado);

        // PDF
        $pdf = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/pdf/'.$model->chave.'-mdfe.pdf';

        $configFile = Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json';
        $configData = file_get_contents($configFile);
        $config     = json_decode($configData, true);
        $logo       = $config['aDocFormat']['pathLogoFile'];

        $dacte = new Damdfe($xmlfile, 'P', 'A4', $logo);
        $id    = $dacte->buildMDFe();
        $salva = $dacte->printMDFe($pdf, 'F');

        if (is_file($pdf)) {
            $retorno = [
                'status' => true,
                'filename' => $pdf,
                'erros' => []
            ];
        } else {
            $retorno = [
                'status' => false,
                'filename' => '',
                'erros' => ['Arquivo não gerado']
            ];
        }

        return $retorno;
    }

    public function consultaChave($id)
    {
        $model = $this->findModel($id);

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        $aRetorno = array();

        $mdfeTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Retorno
        $protocolo = Yii::getAlias('@mdfe').'/'.$pamb.'/temporarias/'.date('Y').date('m').'/'.$model->chave.'-retConsSitMDFe.xml';

        // Assinadas
        $assinado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/assinadas/'.$model->chave.'-mdfe.xml';

        // Autorizado
        $autorizado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/enviadas/aprovadas/'.$model->chave.'-mdfe.xml';

        // Cancelado
        $cancelado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/canceladas/'.$model->chave.'-mdfe.xml';

        // Verifica o status pela Chave
        $verifica = $mdfeTools->sefazConsultaChave($model->chave,
            $model->ambiente, $aRetorno);

        if (!empty($aRetorno)) {
            // Cancelado
            if ($aRetorno['cStat'] == '101') {

                // Adiciona evento de Cancelamento
                $salvar = $mdfeTools->addCancelamento($autorizado, $protocolo,
                    true);
                //chmod($cancelado, 0777);
                file_put_contents($cancelado, $salvar);

                $retorno       = [
                    'status' => true,
                    'filename' => $cancelado,
                    'erros' => []
                ];
                $model->status = 'CANCELADO';
                $model->save(false);
            }

            // Autorizado
            if ($aRetorno['cStat'] == '100') {
                $salvar = $mdfeTools->addProtocolo($assinado, $protocolo, true);
                //chmod($autorizado, 0777);
                file_put_contents($autorizado, $salvar);

                $retorno = [
                    'status' => true,
                    'filename' => $autorizado,
                    'erros' => []
                ];

                $model->status = 'AUTORIZADO';
                $model->save(false);
            }
        }

        return (isset($retorno)) ? $retorno : ['Não houve retorno'];
    }

    public function sefazCancela($id, $motivo)
    {
        $model = $this->findModel($id);

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        $mdfeTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Autorizado
        $autorizado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/enviadas/aprovadas/'.$model->chave.'-mdfe.xml';

        // ProtCancel
        $protocolo = Yii::getAlias('@mdfe').'/'.$pamb.'/temporarias/'.date('Y').date('m').'/'.$model->chave.'-CancMDFe-retEventoMDFe.xml';

        // Cancelado
        $cancelado = Yii::getAlias('@mdfe/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/canceladas/'.$model->chave.'-mdfe.xml';

        // Retorno do cancelamento
        $aRetorno = array();

        $cancela = $mdfeTools->sefazCancela($model->chave, $model->ambiente,
            '1', $model->mdfeProtocolos[0]->nprot, $motivo, $aRetorno);

        // Verifica se foi cancelado e vinculado
        if ($aRetorno['cStat'] == '135') {
            $model->status = 'CANCELADO';
            $model->save(false);

            $add = $mdfeTools->addCancelamento($autorizado, $protocolo);
            file_put_contents($cancelado, $add);
        }

        return $aRetorno;
        //return htmlspecialchars($cteTools->soapDebug);
    }

    public function sefazEncerra($id, $cUF, $cMun)
    {
        $model = $this->findModel($id);

        $mdfeTools = new Tools(Yii::getAlias('@sped/').'config/'.Yii::$app->user->identity['cnpj'].'.json');

        $aRetorno = array();

        $encerra = $mdfeTools->sefazEncerra(
            $model->chave, $model->ambiente, '1',
            $model->mdfeProtocolos[0]->nprot, $cUF, $cMun, $aRetorno);

        if ($aRetorno['cStat'] == '135' || $aRetorno['cStat'] == '631') {
            //Muda o status para ENCERRADO
            $model->status = 'ENCERRADO';
            $model->save(false);            
        }

        //Yii::$app->response->format = Response::FORMAT_JSON;

        return $aRetorno;
    }

    /**
     * Finds the Mdfe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mdfe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mdfe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}