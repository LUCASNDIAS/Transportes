<?php

namespace backend\modules\cte\models;

use backend\modules\cte\models\Cte;
use backend\modules\clientes\models\Clientes;
use backend\modules\cte\models\CteProtocolo;
use NFePHP\CTe\Make;
use NFePHP\CTe\Tools;
use NFePHP\DA\CTe\DacteV3 as Dacte;
use backend\models\Municipios;
use Yii;

class CteGeral
{

    public function gerarXml($id)
    {
        // Carrega modelo
        $model = $this->findModel($id);

        $cte = new Make();

        $cteTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Pesquisas relacionadas aos clientes
        $cliente = new Clientes();

        // Pesquisas relacionadas aos Municípios (IBGE)
        $municipio = new Municipios();

        // Remover caracteres inválidos
        $invalidos = array("(", ")", "-", ".");

        $dhEmi = str_replace(' ', 'T', $model->dtemissao);
        $dhEmi .= date('P');

        $chave = $model->chave;

        $resp   = $cte->infCteTag($chave, $versao = '3.00');

        $cDV = substr($chave, -1);      //Digito Verificador

        $resp       = $cte->ideTag(
            $cUF        = $cteTools->aConfig['cUF'], // Codigo da UF da tabela do IBGE
            $cCT        = '09835783', // Codigo numerico que compoe a chave de acesso (Codigo aleatorio do emitente, para evitar acessos indevidos ao documento)
            $CFOP       = $model->cfop, // Codigo fiscal de operacoes e prestacoes
            $natOp      = substr($model->natop, 0, 60), // Natureza da operacao
            $mod        = $model->modelo, // Modelo do documento fiscal: 57 para identificação do CT-e
            //$forPag     = $model->forpag, // 0-Pago; 1-A pagar; 2-Outros
            $serie      = $model->serie, // Serie do CTe
            $nCT        = $model->numero, // Numero do CTe
            $dhEmi, // Data e hora de emissão do CT-e: Formato AAAA-MM-DDTHH:MM:DD
            $tpImp      = '1', // Formato de impressao do DACTE: 1-Retrato; 2-Paisagem.
            $tpEmis     = $model->tpemis, // Forma de emissao do CTe: 1-Normal; 4-EPEC pela SVC; 5-Contingência
            $cDV, // Codigo verificador
            $tpAmb      = $model->ambiente, // 1- Producao, 2-homologacao
            $tpCTe      = $model->tpcte, // 0- CT-e Normal; 1 - CT-e de Complemento de Valores; 2 -CT-e de Anulação; 3 - CT-e Substituto
            //$procEmi: 0- emissão de CT-e com aplicativo do contribuinte;
            //          1- emissão de CT-e avulsa pelo Fisco;
            //          2- emissão de CT-e avulsa, pelo contribuinte com seu certificado digital, através do site do Fisco;
            //          3- emissão CT-e pelo contribuinte com aplicativo fornecido pelo Fisco.
            $procEmi    = '0', // Descricao no comentario acima
            $verProc    = '2.0', // versao do aplicativo emissor
            //$refCTE     = $model->refcte, // Chave de acesso do CT-e referenciado
            $indGlobalizado = '',
            $cMunEnv    = $model->cmunenv, // Utilizar a tabela do IBGE. Informar 9999999 para as operações com o exterior.
            $xMunEnv    = $model->xmunenv, // Informar PAIS/Municipio para as operações com o exterior.
            $UFEnv      = $model->ufenv, // Informar 'EX' para operações com o exterior.
            $modal      = $model->modal, // Preencher com:01-Rodoviário; 02-Aéreo; 03-Aquaviário;04-
            $tpServ     = $model->tpserv, // 0- Normal; 1- Subcontratação; 2- Redespacho; 3- Redespacho Intermediário; 4- Serviço Vinculado a Multimodal
            $cMunIni    = $model->cmunini, // Utilizar a tabela do IBGE. Informar 9999999 para as operações com o exterior.
            $xMunIni    = $model->xmunini, // Informar 'EXTERIOR' para operações com o exterior.
            $UFIni      = $model->ufini, // Informar 'EX' para operações com o exterior.
            $cMunFim    = $model->cmunfim, // Utilizar a tabela do IBGE. Informar 9999999 para operações com o exterior.
            $xMunFim    = $model->xmunfim, // Informar 'EXTERIOR' para operações com o exterior.
            $UFFim      = $model->uffim, // Informar 'EX' para operações com o exterior.
            $retira     = $model->retira, // Indicador se o Recebedor retira no Aeroporto, Filial, Porto ou Estação de Destino? 0-sim; 1-não
            $xDetRetira = ($model->retira == '1') ? '' : $model->xdetretira, // Detalhes do retira
            $indIEToma  = $model->indietoma,
            $dhCont     = ($model->tpemis != '5') ? '' : str_replace(' ', 'T',
                $model->dhcont), // Data e Hora da entrada em contingência; no formato AAAAMM-DDTHH:MM:SS
            $xJust      = ($model->tpemis != '5') ? '' : $model->xjust // Justificativa da entrada em contingência
        );

        if ($model->toma == '4') {
            // Tomador informado não é envolvido no frete
            // Tem que montar a tag com dados
            // Dados do tomador
            $tomador = $cliente::find()
                ->where(['dono' => Yii::$app->user->identity['cnpj']])
                ->andWhere(['cnpj' => $model->tomador])
                ->one();

            // Codigo do Municipio do tomador
            $muntomador = $municipio::find()
                ->where(['municipio' => $tomador->endcid])
                ->andWhere(['uf' => $tomador->enduf])
                ->one();

            // Informações Gerais do tomador
            $resp  = $cte->toma4Tag(
                $toma  = $model->toma, // 4-Outros, informar os dados cadastrais do tomador quando ele for outros
                $CNPJ  = (isset($tomador->cnpj[13])) ? $tomador->cnpj : '', // CNPJ
                $CPF   = (isset($tomador->cnpj[13])) ? '' : $tomador->cnpj, // CPF
                $IE    = ($model->indietoma != 9) ? $tomador->ie : null, // Iscricao estadual
                $xNome = ($model->ambiente == 1) ? substr($tomador->nome, 0, 60)
                    : 'CT-E EMITIDO EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL', // Razao social ou Nome
                $xFant = '', // Nome fantasia
                $fone  = (isset($tomador->clientesContatos[0]->telefone)) ? str_replace($invalidos,
                    '', $tomador->clientesContatos[0]->telefone) : '', // Telefone
                $email = ''// (isset($tomador->clientesContatos[0]->email)) ? strtolower($tomador->clientesContatos[0]->email)
                //: ''   // email
            );

            // Endereço do Tomador
            $resp    = $cte->enderTomaTag(
                $xLgr    = $tomador->endrua, // Logradouro
                $nro     = '0'.$tomador->endnro, // Numero
                $xCpl    = '', // COmplemento
                $xBairro = $tomador->endbairro, // Bairro
                $cMun    = $muntomador->codigo, // Codigo do municipio do IBEGE Informar 9999999 para operações com o exterior.
                $xMun    = $tomador->endcid, // Nome do município (Informar EXTERIOR para operações com o exterior.
                $CEP     = str_replace($invalidos, '', $tomador->endcep), // CEP
                $UF      = $tomador->enduf, // Sigla UF (Informar EX para operações com o exterior.)
                $cPais   = '1058', // Codigo do país ( Utilizar a tabela do BACEN )
                $xPais   = 'BRASIL'                   // Nome do pais
            );
        } else {
            // Tomador do serviço diferente de outros
            $resp = $cte->toma3Tag(
                $toma = $model->toma                 // Indica o "papel" do tomador: 0-Remetente; 1-Expedidor; 2-Recebedor; 3-Destinatário
            );
        }

        // Informações complementares
        $resp = $cte->complTag($model->xcaracad, $model->xcaracser, '', '', '', $model->xobs);

        // Informações do EMITENTE
        // Endereço do Emitente
        $emitente = $cliente::find()
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            ->andWhere(['cnpj' => $cteTools->aConfig['cnpj']])
            ->one();

        // Codigo do Municipio do tomador
        $munemitente = $municipio::find()
            ->where(['municipio' => $emitente->endcid])
            ->andWhere(['uf' => $emitente->enduf])
            ->one();

        $resp  = $cte->emitTag(
            $CNPJ  = $cteTools->aConfig['cnpj'], // CNPJ do emitente
            $IE    = $emitente->ie, // Inscricao estadual
            $IEST  = '',
            $xNome = $cteTools->aConfig['razaosocial'], // Razao social
            $xFant = $cteTools->aConfig['nomefantasia'] // Nome fantasia
        );

        $resp    = $cte->enderEmitTag(
            $xLgr    = $emitente->endrua, // Logradouro
            $nro     = '0'.$emitente->endnro, // Numero
            $xCpl    = '', // Complemento
            $xBairro = $emitente->endbairro, // Bairro
            $cMun    = $munemitente->codigo, // Código do município (utilizar a tabela do IBGE)
            $xMun    = $emitente->endcid, // Nome do municipio
            $CEP     = str_replace($invalidos, '', $emitente->endcep), // CEP
            $UF      = $emitente->enduf, // Sigla UF
            $fone    = (isset($emitente->clientesContatos[0]->telefone)) ? str_replace($invalidos,
                '', $emitente->clientesContatos[0]->telefone) : '' // Fone
        );

        // Informações do REMETENTE
        // Dados do remetente
        $remetente = $cliente::find()
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            ->andWhere(['cnpj' => $model->remetente])
            ->one();

        // Codigo do Municipio do remetente
        $munremetente = $municipio::find()
            ->where(['municipio' => $remetente->endcid])
            ->andWhere(['uf' => $remetente->enduf])
            ->one();

        $resp  = $cte->remTag(
            $CNPJ  = (isset($remetente->cnpj[13])) ? $remetente->cnpj : '', // CNPJ
            $CPF   = (isset($remetente->cnpj[13])) ? '' : $remetente->cnpj, // CPF
            $IE    = ($model->indietoma == 9 && $model->toma == 0) ? null : $remetente->ie, // Iscricao estadual
            $xNome = ($model->ambiente == 1) ? substr($remetente->nome, 0, 60) : 'CT-E EMITIDO EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL', // Razao social ou Nome
            $xFant = '', // Nome fantasia
            $fone  = (isset($remetente->clientesContatos[0]->telefone)) ? str_replace($invalidos,
                '', $remetente->clientesContatos[0]->telefone) : '', // Telefone
            $email = (isset($remetente->clientesContatos[0]->email)) ? strtolower($remetente->clientesContatos[0]->email)
                : ''   // email
        );

        $resp    = $cte->enderRemeTag(
            $xLgr    = $remetente->endrua, // Logradouro
            $nro     = $remetente->endnro, // Numero
            $xCpl    = '', // COmplemento
            $xBairro = $remetente->endbairro, // Bairro
            $cMun    = (isset($munremetente->codigo)) ? $munremetente->codigo : '9999999', // Codigo do municipio do IBEGE Informar 9999999 para operações com o exterior.
            $xMun    = $remetente->endcid, // Nome do município (Informar EXTERIOR para operações com o exterior.
            $CEP     = str_replace($invalidos, '', $remetente->endcep), // CEP
            $UF      = $remetente->enduf, // Sigla UF (Informar EX para operações com o exterior.)
            $cPais   = '1058', // Codigo do país ( Utilizar a tabela do BACEN )
            $xPais   = 'BRASIL'                   // Nome do pais              // Nome do pais
        );

        // Informações do EXPEDIDOR
        if ($model->expedidor != '') {
            // Dados do expedidor
            $expedidor = $cliente::find()
                ->where(['dono' => Yii::$app->user->identity['cnpj']])
                ->andWhere(['cnpj' => $model->expedidor])
                ->one();

            // Codigo do Municipio do expedidor
            $munexpedidor = $municipio::find()
                ->where(['municipio' => $expedidor->endcid])
                ->andWhere(['uf' => $expedidor->enduf])
                ->one();

            $resp  = $cte->expedTag(
                $CNPJ  = (isset($expedidor->cnpj[13])) ? $expedidor->cnpj : '', // CNPJ
                $CPF   = (isset($expedidor->cnpj[13])) ? '' : $expedidor->cnpj, // CPF
                $IE    = ($model->indietoma == 9 && $model->toma == 1) ? null : $expedidor->ie, // Iscricao estadual
                $xNome = ($model->ambiente == 1) ? substr($expedidor->nome, 0,
                    60) : 'CT-E EMITIDO EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL', // Razao social ou Nome
                $fone  = (isset($expedidor->clientesContatos[0]->telefone)) ? str_replace($invalidos,
                    '', $expedidor->clientesContatos[0]->telefone) : '', // Telefone
                $email = (isset($expedidor->clientesContatos[0]->email)) ? strtolower($expedidor->clientesContatos[0]->email)
                    : ''   // email
            );

            $resp    = $cte->enderExpedTag(
                $xLgr    = $expedidor->endrua, // Logradouro
                $nro     = $expedidor->endnro, // Numero
                $xCpl    = '', // COmplemento
                $xBairro = $expedidor->endbairro, // Bairro
                $cMun    = $munexpedidor->codigo, // Codigo do municipio do IBEGE Informar 9999999 para operações com o exterior.
                $xMun    = $expedidor->endcid, // Nome do município (Informar EXTERIOR para operações com o exterior.
                $CEP     = str_replace($invalidos, '', $expedidor->endcep), // CEP
                $UF      = $expedidor->enduf, // Sigla UF (Informar EX para operações com o exterior.)
                $cPais   = '1058', // Codigo do país ( Utilizar a tabela do BACEN )
                $xPais   = 'BRASIL'                   // Nome do pais              // Nome do pais
            );
        }

        // Informações do RECEBEDOR
        if ($model->recebedor != '') {
            // Dados do recebedor
            $recebedor = $cliente::find()
                ->where(['dono' => Yii::$app->user->identity['cnpj']])
                ->andWhere(['cnpj' => $model->recebedor])
                ->one();

            // Codigo do Municipio do recebedor
            $munrecebedor = $municipio::find()
                ->where(['municipio' => $recebedor->endcid])
                ->andWhere(['uf' => $recebedor->enduf])
                ->one();

            $resp  = $cte->recebTag(
                $CNPJ  = (isset($recebedor->cnpj[13])) ? $recebedor->cnpj : '', // CNPJ
                $CPF   = (isset($recebedor->cnpj[13])) ? '' : $recebedor->cnpj, // CPF
                $IE    = ($model->indietoma == 9 && $model->toma == 2) ? null : $recebedor->ie, // Iscricao estadual
                $xNome = ($model->ambiente == 1) ? substr($recebedor->nome, 0,
                    60) : 'CT-E EMITIDO EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL', // Razao social ou Nome
                $fone  = (isset($recebedor->clientesContatos[0]->telefone)) ? str_replace($invalidos,
                    '', $recebedor->clientesContatos[0]->telefone) : '', // Telefone
                $email = (isset($recebedor->clientesContatos[0]->email)) ? strtolower($recebedor->clientesContatos[0]->email)
                    : ''   // email
            );

            $resp    = $cte->enderRecebTag(
                $xLgr    = $recebedor->endrua, // Logradouro
                $nro     = $recebedor->endnro, // Numero
                $xCpl    = '', // COmplemento
                $xBairro = $recebedor->endbairro, // Bairro
                $cMun    = $munrecebedor->codigo, // Codigo do municipio do IBEGE Informar 9999999 para operações com o exterior.
                $xMun    = $recebedor->endcid, // Nome do município (Informar EXTERIOR para operações com o exterior.
                $CEP     = str_replace($invalidos, '', $recebedor->endcep), // CEP
                $UF      = $recebedor->enduf, // Sigla UF (Informar EX para operações com o exterior.)
                $cPais   = '1058', // Codigo do país ( Utilizar a tabela do BACEN )
                $xPais   = 'BRASIL'                   // Nome do pais              // Nome do pais
            );
        }

        // Informações do DESTINATARIO
        // Somente se houver, é claro

        if ($model->destinatario != '') {
            // Dados do destinatario
            $destinatario = $cliente::find()
                ->where(['dono' => Yii::$app->user->identity['cnpj']])
                ->andWhere(['cnpj' => $model->destinatario])
                ->one();

            // Codigo do Municipio do remetente
            $mundestinatario = $municipio::find()
                ->where(['municipio' => $destinatario->endcid])
                ->andWhere(['uf' => $destinatario->enduf])
                ->one();

            $resp  = $cte->destTag(
                $CNPJ  = (isset($destinatario->cnpj[13])) ? $destinatario->cnpj : '', // CNPJ
                $CPF   = (isset($destinatario->cnpj[13])) ? '' : $destinatario->cnpj, // CPF
                $IE    = ($model->indietoma == 9 && $model->toma == 3) ? null : $destinatario->ie, // Iscricao estadual
                $xNome = ($model->ambiente == 1) ? substr($destinatario->nome,
                    0, 60) : 'CT-E EMITIDO EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL', //CT-E EMITIDO EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL     ERONICE GONCALVES CARDOSO
                $fone  = (isset($destinatario->clientesContatos[0]->telefone)) ? str_replace($invalidos,
                    '', $destinatario->clientesContatos[0]->telefone) : '', // Fone
                $ISUF  = '', // Inscrição na SUFRAMA
                $email = (isset($destinatario->clientesContatos[0]->email)) ? strtolower($destinatario->clientesContatos[0]->email)
                    : '' // Email
            );

            $resp    = $cte->enderDestTag(
                $xLgr    = $destinatario->endrua, // Logradouro
                $nro     = $destinatario->endnro, // Numero
                $xCpl    = '', // COmplemento
                $xBairro = $destinatario->endbairro, // Bairro
                $cMun    = $mundestinatario->codigo, // Codigo do municipio do IBEGE Informar 9999999 para operações com o exterior.
                $xMun    = $destinatario->endcid, // Nome do município (Informar EXTERIOR para operações com o exterior.
                $CEP     = str_replace($invalidos, '', $destinatario->endcep), // CEP
                $UF      = $destinatario->enduf, // Sigla UF (Informar EX para operações com o exterior.)
                $cPais   = '1058', // Codigo do país ( Utilizar a tabela do BACEN )
                $xPais   = 'BRASIL'                   // Nome do pais              // Nome do pais
            );
        }

        // Valor total da Prestação
        $resp    = $cte->vPrestTag(
            $vTPrest = number_format($model->vtprest, 2, '.', ''), // Valor total da prestacao do servico
            $vRec    = number_format($model->vrec, 2, '.', '')     // Valor a receber
        );

        // Componetes do frete R$
        foreach ($model->cteComponentes as $componente) {
            $resp  = $cte->compTag(
                $xNome = $componente->nome, // Nome do componente
                $vComp = number_format($componente->valor, 2, '.', '') // Valor do componente
            );
        }

        // ICMS
        $resp       = $cte->icmsTag(
            $cst        = ($model->cst == '90') ? 'SN' : $model->cst,
            $pRedBC     = number_format($model->predbc, 2, '.', ''), // Percentual de redução da BC (3 inteiros e 2 decimais)
            $vBC        = number_format($model->vbc, 2, '.', ''), // Valor da BC do ICMS
            $pICMS      = number_format($model->picms, 2, '.', ''), // Alícota do ICMS
            $vICMS      = number_format($model->vicms, 2, '.', ''), // Valor do ICMS
            $vBCSTRet   = number_format($model->vbcstret, 2, '.', ''), // Valor da BC do ICMS ST retido
            $vICMSSTRet = number_format($model->vicmsret, 2, '.', ''), // Valor do ICMS ST retido
            $pICMSSTRet = number_format($model->picmsret, 2, '.', ''), // Alíquota do ICMS
            $vCred      = number_format($model->vcred, 2, '.', ''), // Valor do Crédito Outorgado/Presumido
            $vTotTrib   = number_format($model->vtottrib, 2, '.', ''), // Valor de tributos federais, estaduais e municipais
            $outraUF    = false,    // ICMS devido à UF de origem da prestação, quando diferente da UF do emitente
            $vBCUFFim = ($model->indietoma == 9 && $model->toma == 3) ? number_format($model->vbc, 2, '.', '') : '',
            $pFCPUFFim = ($model->indietoma == 9 && $model->toma == 3) ? number_format(2, 2, '.', '') : '',
            $pICMSUFFim = ($model->indietoma == 9 && $model->toma == 3) ? number_format(18, 2, '.', '') : '',
            $pICMSInter = ($model->indietoma == 9 && $model->toma == 3) ? number_format(7, 2, '.', '') : '',
            $pICMSInterPart = ($model->indietoma == 9 && $model->toma == 3) ? number_format(60, 2, '.', '') : '',
            $vFCPUFFim = ($model->indietoma == 9 && $model->toma == 3) ? number_format($model->vbc*0.02, 2, '.', '') : '',
            $vICMSUFFim = ($model->indietoma == 9 && $model->toma == 3) ? number_format(($model->vtottrib*0.6)*0.5, 2, '.', '') : 0,
            $vICMSUFIni = ($model->indietoma == 9 && $model->toma == 3) ? number_format($model->vtottrib - (($model->vtottrib*0.6)*0.5), 2, '.', '') : 0
        );

        // Grupo de informações do CT-e Normal e Substituto
        $resp = $cte->infCTeNormTag();

        // Informações da Carga
        $resp     = $cte->infCargaTag(
            $vCarga   = number_format($model->vcarga, 2, '.', ''), // Valor total da carga
            $prodPred = $model->prodpred, // Produto predominante
            $xOutCat  = $model->xoutcat // Outras caracteristicas da carga
        );

        // Quantidade de Carga
        foreach ($model->cteQtags as $qtde) {
            $resp   = $cte->infQTag(
                $cUnid  = $qtde->cunid, // Código da Unidade de Medida: ( 00-M3; 01-KG; 02-TON; 03-UNIDADE; 04-LITROS; 05-MMBTU
                $tpMed  = $qtde->tpmed, // Tipo de Medida ( PESO BRUTO, PESO DECLARADO, PESO CUBADO, PESO AFORADO, PESO AFERIDO, LITRAGEM, CAIXAS e etc)
                $qCarga = number_format($qtde->qcarga, 4, '.', '') // Quantidade (15 posições, sendo 11 inteiras e 4 decimais.)
            );
        }

        // Grupo de informações da
        $resp = $cte->infDocTag();

        // Documentos
        foreach ($model->cteDocumentos as $notas) {
            // Verifica se é nota fiscal eletrônica
            if ($notas->tipo == 'NFE') {
                $resp   = $cte->infNFeTag(
                    $pChave = $notas->chave, // Chave de acesso da NF-e
                    $PIN    = $notas->pin, // PIN SUFRAMA
                    $dPrev  = '' // Data prevista de entrega
                );
            } else if ($notas->tipo == 'NF') {
                // Informções das Notas Fiscais
                $resp  = $cte->infNFTag(
                    $nRoma = $notas->nroma, $nPed  = $notas->nped,
                    $mod   = $notas->modelo, $serie = $notas->serie,
                    $nDoc  = $notas->chave, $dEmi  = $notas->demi,
                    $vBC   = $notas->vbc, $vICMS = $notas->vicms,
                    $vBCST = $notas->vbcst, $vST   = $notas->vst,
                    $vProd = number_format($notas->vnf, 2, '.', ''), 
                    $vNF   = number_format($notas->vnf, 2, '.', ''),
                    $nCFOP = $notas->ncfop,
                    $nPeso = number_format($notas->peso, 3, '.', ''),
                    $PIN   = $notas->pin, $dPrev = ''
                );
            } else {
                $resp       = $cte->infOutrosTag(
                    $tpDoc      = '99', $descOutros = 'OUTROS',
                    $nDoc       = $notas->chave, $dEmi       = '',
                    $vDocFisc   = '', $dPrev      = ''
                );
            }
        }

        // Informações do Modal
        $resp        = $cte->infModalTag($versaoModal = '3.00');

//        $resp    = $cte->segTag(
//            $respSeg = $model->respseg, // Responsavel pelo seguro (0-Remetente; 1-Expedidor; 2-Recebedor; 3-Destinatário; 4-Emitente do CT-e; 5-Tomador de Serviço)
//            $xSeg    = $model->xseg, // Nomeda da Seguradora
//            $nApol   = $model->napol  // Numero da Apolice
//        );

        // Modal Rodoviário
        $resp  = $cte->rodoTag(
            $RNTRC = $model->rntrc, // Registro Nacional de Transportadores Rodoviários de Carga
            $dPrev = $model->dprev, // Data prevista para entrega da carga no recebedor formato ( aaaa-mm-dd )
            $lota  = $model->lota, // Indicador de lotacao ( 0-nao; 1-sim) Será lotação quando houver um único crt por veículo, ou combinação veicular, e por viagem.
            $CIOT  = ''
        );

        // Dados dos veículos
        foreach ($model->cteVeiculos as $veiculo) {
            $resp    = $cte->veicTag(
                $RENAVAM = $veiculo->veiculos->renavam, // RENAVAM do veículo
                $placa   = $veiculo->veiculos->placa, // Placa do veiculo
                $tara    = $veiculo->veiculos->tara, // Tara em KG
                $capKG   = $veiculo->veiculos->capkg, // Capacidade em KG
                $capM3   = $veiculo->veiculos->capm3, // Capacidade em M3
                $tpProp  = $veiculo->veiculos->tpprop, // Tipo de Propriedade de veiculo ( P- Próprio; T- terceiro. Será próprio quando proprietario do veículo for o Emitente do CT-e )
                $tpVeic  = $veiculo->veiculos->tpveic->codigo, // Tipo de veículo ( 0-Tração; 1-Reboque )
                $tpRod   = $veiculo->veiculos->tprod->codigo, // Tipo de Rodaddo ( 00 - não aplicável; 01 - Truck; 02 - Toco; 03 - Cavalo Mecânico; 04 - VAN; 05 - Utilitário; 06 - Outros.)
                $tpCar   = $veiculo->veiculos->tpcar->codigo, // Tipo de carroceria ( 00 - não aplicável; 01 - Aberta; 02 - Fechada/Baú; 03 - Granelera; 04 - Porta Container; 05 - Sider)
                $UF      = $veiculo->veiculos->uf // Sigla UF de licenciamento do veiculo
            );
        }

        foreach ($model->cteMotoristas as $motorista) {
            $resp  = $cte->motoTag(
                $xNome = $motorista->motorista->nome, // Nome do motorista
                $CPF   = str_replace($invalidos, '', $motorista->motorista->cpf)   // CPF do motorista
            );
        }

        // Monta o CTE
        $resp = $cte->montaCTe();

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        // Nome do Arquivo
        $filename = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/geradas/'.$model->chave.'-cte.xml';

        // Verifica se houve erro ao montar o arquivo
        if ($resp) {
            $xml = $cte->getXML();
            file_put_contents($filename, $xml);
            chmod($filename, 0777);

            $retorno = [
                'status' => true,
                'filename' => $filename,
                'erros' => [],
            ];
        } else {

            foreach ($cte->erros as $err) {
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

        $cteTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        // Arquivo a ser assinado
        $filename = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/geradas/'.$model->chave.'-cte.xml';

        // Assina o arquivo e cria outro na pasta assinadas
        $assinado = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/assinadas/'.$model->chave.'-cte.xml';

        // Conteúdo do arquivo
        $xml = file_get_contents($filename);

        // Assina o documento
        $xml = $cteTools->assina($xml);
        file_put_contents($assinado, $xml);
        chmod($assinado, 0777);

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

        $cteTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        // Arquivo assinado
        $assinado = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/assinadas/'.$model->chave.'-cte.xml';

        // Valida o arquivo e move para a pasta de validadas
        $validado = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/validadas/'.$model->chave.'-cte.xml';

        // Mensagem de possíveis erros
        $msg = [];

        // Executa a validação do arquivo
        if (!$cteTools->validarXml($assinado) || sizeof($cteTools->erros)) {
            $msg[] = "<h3>Algum erro ocorreu.... </h3>";
            foreach ($cteTools->erros as $erro) {
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

        $cteTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        // Arquivo Validado
        $validado = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/validadas/'.$model->chave.'-cte.xml';

        // Verifica se o arquivo existe
        if (!is_file($validado)) {
            $retorno = [
                'status' => false,
                'filename' => '',
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
        $retorno = $cteTools->sefazEnvia($xml, $tpAmb, $idLote, $aRetorno,
            $indSinc, $flagZip);

        return $aRetorno;
    }

    public function reciboXml($id, $recibo)
    {
        $model     = $this->findModel($id);
        $tpAmb     = $model->ambiente;
        $aResposta = array();

        $cteTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Verifica o status pelo recibo
        $retorno = $cteTools->sefazConsultaRecibo($recibo, $tpAmb, $aResposta);

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
        $model = new CteProtocolo();

        $model->cte_id  = $id;
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

        $cteTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Arquivo Validado
        $validado = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/validadas/'.$model->chave.'-cte.xml';

        // Protocolo
        $protocolo = Yii::getAlias('@cte/').$pamb.'/temporarias/'.date('Y').date('m').'/'.$recibo.'-retConsReciCTe.xml';

        //return $protocolo;

        // Autorizado
        $autorizado = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/enviadas/aprovadas/'.$model->chave.'-cte.xml';

        if (!is_file($protocolo)) {
            $retorno = [
                'status' => false,
                'filename' => $protocolo,
                'erros' => ['Protocolo não localizado.']
            ];
        } else {
            $salvar = $cteTools->addProtocolo($validado, $protocolo, true);
            file_put_contents($autorizado, $salvar);

            $retorno = [
                'status' => true,
                'filename' => $autorizado,
                'erros' => []
            ];

            // Altera o status do CTe para Autorizado
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

        $cteTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        if ($model->status === 'CANCELADO') {
            // Cancelado
            $autorizado = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/canceladas/'.$model->chave.'-cte.xml';
        } else if ($model->status === 'AUTORIZADO') {
            // Autorizado
            $autorizado = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/enviadas/aprovadas/'.$model->chave.'-cte.xml';
        } else {
            // Assina o arquivo e cria outro na pasta assinadas
            $autorizado = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/assinadas/'.$model->chave.'-cte.xml';
            
            if (!is_file($autorizado)) {
                $autorizado = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/geradas/'.$model->chave.'-cte.xml';
            }

            $enviado = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/enviadas/aprovadas/'.$model->chave.'-cte.xml';

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
        $pdf = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/pdf/'.$model->chave.'-cte.pdf';

        $configFile = Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json';
        $configData = file_get_contents($configFile);
        $config     = json_decode($configData, true);
        $logo       = $config['aDocFormat']['pathLogoFile'];

        $dacte = new Dacte($xmlfile, 'P', 'A4', $logo);
        $id    = $dacte->montaDACTE();
        $salva = $dacte->printDACTE($pdf, 'F');

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

    public function sefazCancela($id, $motivo)
    {
        $model = $this->findModel($id);

        // Verifica se é homologação ou produção
        $pamb = ($model->ambiente == 1) ? 'producao' : 'homologacao';

        $cteTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        // Autorizado
        $autorizado = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/enviadas/aprovadas/'.$model->chave.'-cte.xml';

        // ProtCancel
        $protocolo = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/temporarias/'.date('Y').date('m').'/'.$model->chave.'-CancCTe-retEnvEvento.xml';

        // Cancelado
        $cancelado = Yii::getAlias('@cte/').Yii::$app->user->identity['cnpj'].'/'.$pamb.'/canceladas/'.$model->chave.'-cte.xml';

        // Retorno do cancelamento
        $aRetorno = array();

        $cancela = $cteTools->sefazCancela($model->chave, $model->ambiente,
            $motivo, $model->cteProtocolos[0]->nprot, $aRetorno);

//        $cancela = $cteTools->sefazCancela('31171109204054000143570010000017061282008464', '1',
//            'solicitado pelo cliente', '131170237201932', $aRetorno);

        // Verifica se foi cancelado e vinculado
        if ($aRetorno['cStat'] == '135') {
            $model->status = 'CANCELADO';
            $model->save(false);

            $add = $cteTools->addCancelamento($autorizado, $protocolo);
            file_put_contents($cancelado, $add);
        }

        return $aRetorno;
    }

    /**
     * Finds the Cte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cte::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}