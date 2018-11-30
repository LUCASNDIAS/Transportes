<?php

namespace backend\modules\fatura\models;

use backend\commands\Basicos;
use DOMDocument;
use Exception;
use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use NFePHP\Common\Files;

class BoletoRegistro
{

    /**
     * aConfig
     * Configuração do usuário
     * @var array
     */
    public $aConfig = array();

    /**
     * nuCPFCNPJ (obrigatório)
     * Cnpj ou Cpf do emitente
     * CNPJ: preencher 8 caract
     * CPF: preencher 9 caract
     * Max 9 Caract
     * @var string
     */
    protected $nuCPFCNPJ = '';

    /**
     * filialCPFCNPJ (obrigatório)
     * Filial do emitente (consta no CNPJ)
     * CNPJ: preencher 4 caract
     * CPF: preencher com string '0'
     * Max 4 caract
     * @var string
     */
    protected $filialCPFCNPJ = '';

    /**
     * ctrlCPFCNPJ (obrigatório)
     * Número de controle do CPF / CNPJ
     * Max 2 carac
     * @var string
     */
    protected $ctrlCPFCNPJ = '';

    /**
     * cdTipoAcesso (obrigatório)
     * Tipo de acesso
     * Fixo em '2': Negociação
     * @var string
     */
    protected $cdTipoAcesso = '2';

    /**
     * Club Banco
     * Max 10 caract
     * Fixo em '2269651' ou '0'
     * @var string
     */
    protected $clubBanco = '0';

    /**
     * cdTipoContrato
     * Max 3 caract
     * Fixo em '48' ou '0'
     * @var string
     */
    protected $cdTipoContrato = '0';

    /**
     * nuSequenciaContrato
     * Max 10 caract
     * @var string
     */
    protected $nuSequenciaContrato = '0';

    /**
     * idProduto (obrigatório)
     * Carteira de Cobrança Utilizada
     * Max 2 caract
     * @var string
     */
    protected $idProduto = '09';

    /**
     * nuNegociacao (obrigatório)
     * Número da Negociação a ser utilizada
     * Formato => Agência 4 posições (s/ dígito)
     *            Zeros: 7 posições
     *            Conta: 7 posições (s dígito)
     * Max 18 caract
     * @var string
     */
    protected $nuNegociacao = '';

    /**
     * cdBanco (obrigatório)
     * Código do banco
     * Max 3 caract
     * Fixo em '237'
     * @var string
     */
    protected $cdBanco = '237';

    /**
     * eNuSequenciaContrato
     * Número de Sequência do Contrato
     * Max 10 caract
     * @var string
     */
    protected $eNuSequenciaContrato = '0';

    /**
     * tpRegistro (obrigatório)
     * Tipo de Registro do Boleto
     * Fixo em '1': à vencer / vencido
     * Max 3 caract
     * @var string
     */
    protected $tpRegistro = '1';

    /**
     * cdProduto
     * Código do Produto
     * Max 8 caract
     * @var string
     */
    protected $cdProduto = '0';

    /**
     * nuTitulo
     * Nosso Número sem o dígito
     * Identificação do título para o banco. Pode ser
     * informado pleo cliente ou gerado pelo banco.
     * Esse Número deve ser único de acordo com a
     * carteira e negociação utilizadas.
     * Max 11 caract
     * @var string
     */
    protected $nuTitulo = '0';

    /**
     * nuCliente (obrigatório)
     * Número do Cliente (seu número)
     * Identificação do título para o cliente
     * Max 10 caract
     * @var string
     */
    protected $nuCliente = '';

    /**
     * dtEmissaoTitulo (obrigatório)
     * Data de Emissão do Título
     * Formato: DD.MM.AAAA
     * Max 10 caract
     * @var string
     */
    protected $dtEmissaoTitulo = '';

    /**
     * dtVencimentoTitulo (obrigatório)
     * Data de Vencimento do Título
     * Esta data não pode ser menor que a data
     * de emissão do Título.
     * Formato: DD.MM.AAAA
     * Max 10 Caract
     * @var string
     */
    protected $dtVencimentoTitulo = '';

    /**
     * tpVencimento (obrigatório)
     * Tipo de Vencimento
     * Fixo em '0'
     * Max 1 caract
     * @var string
     */
    protected $tpVencimento = '0';

    /**
     * vlNominalTitulo (obrigatório)
     * Valor nominal do título
     * Se moeda Real preencher no formato 10000 (p/ R$ 100,00)
     * Se moeda indexada, preencher no formato 10000000 (U$ 100,00)
     * Max 17 caract
     * @var string
     */
    protected $vlNominalTitulo = '';

    /**
     * cdEspecieTitulo (obrigatório)
     * Código da Espécie do Título
     * Códigos possíveis de acordo com item 9.1 do manual
     * Max 2 caract
     * @var string
     */
    protected $cdEspecieTitulo = '02';

    /**
     * tpProtestoAutomaticoNegativacao
     * Tipo de Protesto Automático ou Negativação
     * Opções => '0' - sem protesto automático
     *           '01' - Dias corridos para protesto
     *           '02' - Dias úteis para protesto
     *           '03' - Dias corridos para negativação
     * Max 2 caract
     * @var string
     */
    protected $tpProtestoAutomaticoNegativacao = '0';

    /**
     * prazoProtestoAutomaticoNegativacao
     * Obrigatório se tpProtestoAutomaticoNegativacao != '0'
     * Prazo de Protesto (mínimo de 5 dias)
     * @var string
     */
    protected $prazoProtestoAutomaticoNegativacao = '0';

    /**
     * controleParticipante
     * Campo de responsabilidade do cliente,
     * não consistido pelo banco
     * Max 25 caract
     * @var string
     */
    protected $controleParticipante = '';

    /**
     * cdPagamentoParcial
     * Indicador de pagamento parcial, segundo
     * regra da nova Plataforma de Cobrança
     * Opções => '', 'S' ou 'N'
     * Max 1 caract
     * @var string
     */
    protected $cdPagamentoParcial = '';

    /**
     * qtdePagamentoParcial
     * Obrigatorio se cdPagamentoParcial == 'S'
     * Quantidade de pagamentos parciais
     * Max 3 caract
     * @var string
     */
    protected $qtdePagamentoParcial = '0';

    /**
     * percentualJuros
     * Percentual de Juros
     * Formato => NNNDDDDD
     * Sendo, N Inteiros e D decimais.
     * Ex.: 10% -> 01000000 | 12,15% -> 01215000
     * Max 8 caract
     * @var string
     */
    protected $percentualJuros = '0';

    /**
     * vlJuros
     * Valor d Juros
     * Não preencher se precentualJuros != '0'
     * Max 17 caract
     * @var string
     */
    protected $vlJuros = '0';

    /**
     * qtdeDiasJuros
     * Quantidade de dias para cálculo de juros
     * max 2 caract
     * @var string
     */
    protected $qtdeDiasJuros = '0';

    /**
     * percentualMulta
     * Percentual de Multa
     * Mesmo formato do percentual de Juros
     * Max 8 caract
     * @var string
     */
    protected $percentualMulta = '0';

    /**
     * vlMulta
     * Valor da Multa
     * Max 17 caract
     * @var string
     */
    protected $vlMulta = '0';

    /**
     * qtdeDiasMulta
     * Quantidade de dias para cálculo da Multa
     * Max 3 caract
     * @var string
     */
    protected $qtdeDiasMulta = '0';

    /**
     * percentualDesconto1
     * Percentual do Desconto 1
     * Mesmo formato de campos percentuais
     * Max 8 caract
     * @var string
     */
    protected $percentualDesconto1 = '0';

    /**
     * vlDesconto1
     * Valor do desconto 1
     * Max 17 caract
     * @var string
     */
    protected $vlDesconto1 = '0';

    /**
     * dataLimiteDesconto1
     * Data Limite para Desconto 1
     * Formato: DD.MM.AAAA
     * Max 10 caract
     * @var string
     */
    protected $dataLimiteDesconto1 = '';

    /**
     * percentualDesconto2
     * Percentual do Desconto 2
     * Mesmo formato de campos percentuais
     * Max 8 caract
     * @var string
     */
    protected $percentualDesconto2 = '0';

    /**
     * vlDesconto2
     * Valor do desconto 2
     * Max 17 caract
     * @var string
     */
    protected $vlDesconto2 = '0';

    /**
     * dataLimiteDesconto2
     * Data Limite para Desconto 2
     * Formato: DD.MM.AAAA
     * Max 10 caract
     * @var string
     */
    protected $dataLimiteDesconto2 = '';

    /**
     * percentualDesconto3
     * Percentual do Desconto 3
     * Mesmo formato de campos percentuais
     * Max 8 caract
     * @var string
     */
    protected $percentualDesconto3 = '0';

    /**
     * vlDesconto3
     * Valor do desconto 3
     * Max 17 caract
     * @var string
     */
    protected $vlDesconto3 = '0';

    /**
     * dataLimiteDesconto3
     * Data Limite para Desconto 3
     * Formato: DD.MM.AAAA
     * Max 10 caract
     * @var string
     */
    protected $dataLimiteDesconto3 = '';

    /**
     * prazoBonificacao
     * Obrigatório se percentualBonificacao != '0'
     * Obrigatório se vlBonificacao != '0'
     * Opções => '0': não se aplica
     *           '1': dias corridos
     *           '2': dias úteis
     * Max 2 caract
     * @var string
     */
    protected $prazoBonificacao = '0';

    /**
     * percentualBonificacao
     * Percentual de Bonificação
     * Formato de percentual
     * Max 8 caract
     * @var string
     */
    protected $percentualBonificacao = '0';

    /**
     * vlBonificacao
     * Valor de Bonificação
     * Max 17 caract
     * @var string
     */
    protected $vlBonificacao = '0';

    /**
     * dtLimiteBonificacao
     * Data limite para Bonificação
     * Obrigatório se percentualBonificacao != '0'
     * Obrigatório se vlBonificacao != '0'
     * Formato: DD.MM.AAAA
     * Max 10 caract
     * @var string
     */
    protected $dtLimiteBonificacao = '';

    /**
     * vlAbatimento
     * Valor do Abatimento
     * Max 17 caract
     * @var string
     */
    protected $vlAbatimento = '0';

    /**
     * vlIOF
     * Valor do IOF
     * Obrigatório para Cobrança Carteira de Seguros
     * @var string
     */
    protected $vlIOF = '0';

    /**
     * nomePagador (obrigatório)
     * Nome do Pagador do Título
     * Max 70 caract
     * @var string
     */
    protected $nomePagador = '';

    /**
     * logradouroPagador (obrigatório)
     * Endereço do Pagador
     * Max 40 caract
     * @var string
     */
    protected $logradouroPagador = '';

    /**
     * nuLogradouroPagador (obrigatório)
     * Número do endereço do Pagador
     * Max 10 caract
     * @var string
     */
    protected $nuLogradouroPagador = '';

    /**
     * complementoLogradouroPagador
     * Complemento do endereço do Pagador
     * Max 15 caract
     * @var string
     */
    protected $complementoLogradouroPagador = '';

    /**
     * cepPagador (obrigatório)
     * CEP do pagador
     * Max 5 caract
     * @var string
     */
    protected $cepPagador = '0';

    /**
     * complementoCepPagador (obrigatório)
     * Complemento do CEP do Pagador
     * Max 3 caract
     * @var string
     */
    protected $complementoCepPagador = '0';

    /**
     * bairroPagador (obrigatório)
     * Bairro do Pagador
     * Max 40 caract
     * @var string
     */
    protected $bairroPagador = '';

    /**
     * municipioPagador  (obrigatório)
     * Município do Pagador
     * Max 30 caract
     * @var string
     */
    protected $municipioPagador = '';

    /**
     * ufPagador (obrigatório)
     * Sigla UF do Pagador
     * Max 2 Caract
     * @var string
     */
    protected $ufPagador = '';

    /**
     * cdIndCpfCnpjPagador (obrigatório)
     * Opções => '1': CPF
     *           '2': CNPJ
     * Max 1 caract
     * @var string
     */
    protected $cdIndCpfcnpjPagador = '';

    /**
     * nuCpfcnpjPagador (obrigatório)
     * Número do CPF ou CNPJ do Pagador
     * Preencher as 14 posições e completar com 0 à esquerda
     * em caso de cdIndCpfcnpjPagador = '1' (CPF)
     * Max 14 caract
     * @var string
     */
    protected $nuCpfcnpjPagador = '';

    /**
     * endEletronicoPagador
     * Endereço Eletrônico Pagador
     * Max 70 caract
     * @var string
     */
    protected $endEletronicoPagador = '';

    /**
     * nomeSacadorAvalista
     * Nome do Sacador Avalista
     * Max 40 caract
     * @var string
     */
    protected $nomeSacadorAvalista = '';

    /**
     * logradouroSacadorAvalista
     * Endereço do Sacador Avalista
     * Obrigatório se nomeSacadorAvalista != ''
     * Max 40 caract
     * @var string
     */
    protected $logradouroSacadorAvalista = '';

    /**
     * nuLogradouroSacadorAvalista
     * Número do Endereço do Sacador Avalista
     * Obrigatório se nomeSacadorAvalista != ''
     * Max 10 caract
     * @var string
     */
    protected $nuLogradouroSacadorAvalista = '0';

    /**
     * complementoLogradouroSacadorAvalista
     * Complemento do Endereço do Sacador Avalista
     * Max 15 caract
     * @var string
     */
    protected $complementoLogradouroSacadorAvalista = '';

    /**
     * cepSacadorAvalista
     * CEP do Sacador Avalista
     * Obrigatório se nomeSacadorAvalista != ''
     * Max 5 caract
     * @var string
     */
    protected $cepSacadorAvalista = '0';

    /**
     * complementoCepSacadorAvalista
     * Complemento do CEP do Sacador Avalista
     * Obrigatório se nomeSacadorAvalista != ''
     * Max 3 caract
     * @var string
     */
    protected $complementoCepSacadorAvalista = '0';

    /**
     * bairroSacadorAvalista
     * Bairro do Sacador Avalista
     * Obrigatório se nomeSacadorAvalista != ''
     * Max 40 caract
     * @var string
     */
    protected $bairroSacadorAvalista = '';

    /**
     * municipioSacadorAvalista
     * Município do Sacador Avalista
     * Obrigatório se nomeSacadorAvalista != ''
     * Max 40 caract
     * @var string
     */
    protected $municipioSacadorAvalista = '';

    /**
     * ufSacadorAvalista
     * Sigla UF do Sacador Avalista
     * Obrigatório se nomeSacadorAvalista != ''
     * Max 2 caract
     * @var string
     */
    protected $ufSacadorAvalista = '';

    /**
     * cdIndCpfcnpjSacadorAvalista
     * Indicador de CPF ou CNPJ do Sacador Avalista
     * Obrigatório se nomeSacadorAvalista != ''
     * Opções => '1': CPF
     *           '2': CPNJ
     * Max 1 caract
     * @var string
     */
    protected $cdIndCpfcnpjSacadorAvalista = '0';

    /**
     * nuCpfcnpjSacadorAvalista
     * Número do CPF ou CNPJ do Sacador Avalista
     * Obrigatório se nomeSacadorAvalista != ''
     * Mesmo formato do CPF ou CNPJ do Pagador
     * Max 14 caract
     * @var string
     */
    protected $nuCpfcnpjSacadorAvalista = '0';

    /**
     * endEletronicoSacadorAvalista
     * Endereço eletrônico do Sacador Avalista
     * Max 70 caract
     * @var string
     */
    protected $endEletronicoSacadorAvalista = '';

    /**
     * urlServico
     * Urls de Prd e Hml para registro de boleto
     * @var array
     */
    protected $urlServico = array(
        'PRODUCAO' => 'https://cobranca.bradesconetempresa.b.br/ibpjregistrotitulows/registrotitulo',
        'HOMOLOGACAO' => 'https://cobranca.bradesconetempresa.b.br/ibpjregistrotitulows/registrotitulohomologacao'
    );

    /**
     * BoletoRegistro constructor.
     * @param string $configJson
     * @throws NotFoundHttpException
     */
    public function __construct($configJson = '')
    {
        if ($configJson == '') {
            $msg = 'O arquivo de configuração no formato JSON deve ser passado para a classe.';
            throw new NotFoundHttpException($msg);
        }
        if (is_file($configJson)) {
            $configJson = Files\FilesFolders::readFile($configJson);
        }
        //carrega os dados de configuração
        $this->aConfig = (array)json_decode($configJson);
    }

    public function criaRemessa($modelBoleto)
    {
        $basicos = new Basicos();

        $this->nuCPFCNPJ = $modelBoleto->nuCPFCNPJ;
        $this->filialCPFCNPJ = $modelBoleto->filialCPFCNPJ;
        $this->ctrlCPFCNPJ = $modelBoleto->ctrlCPFCNPJ;
        $this->cdTipoAcesso = $modelBoleto->cdTipoAcesso;
        $this->clubBanco = $modelBoleto->clubBanco;
        $this->cdTipoContrato = $modelBoleto->cdTipoContrato;
        $this->nuSequenciaContrato = $modelBoleto->nuSequenciaContrato;
        $this->idProduto = $modelBoleto->idProduto;
        $this->nuNegociacao = $modelBoleto->nuNegociacao;
        $this->cdBanco = $modelBoleto->cdBanco;
        $this->eNuSequenciaContrato = $modelBoleto->eNuSequenciaContrato;
        $this->tpRegistro = $modelBoleto->tpRegistro;
        $this->cdProduto = $modelBoleto->cdProduto;
        $this->nuTitulo = $modelBoleto->nuTitulo;
        $this->nuCliente = $modelBoleto->nuCliente;
        $this->dtEmissaoTitulo = $basicos->formataData('boleto', $modelBoleto->dtEmissaoTitulo);
        $this->dtVencimentoTitulo = $basicos->formataData('boleto', $modelBoleto->dtVencimentoTitulo);
        $this->tpVencimento = $modelBoleto->tpVencimento;
        $this->vlNominalTitulo = $basicos->boletoValor($modelBoleto->vlNominalTitulo);
        $this->cdEspecieTitulo = $modelBoleto->cdEspecieTitulo;
        $this->tpProtestoAutomaticoNegativacao = $modelBoleto->tpProtestoAutomaticoNegativacao;
        $this->prazoProtestoAutomaticoNegativacao = $modelBoleto->prazoProtestoAutomaticoNegativacao;
        $this->controleParticipante = $modelBoleto->controleParticipante;
        $this->cdPagamentoParcial = $modelBoleto->cdPagamentoParcial;
        $this->qtdePagamentoParcial = $modelBoleto->qtdePagamentoParcial;
        $this->percentualJuros = $basicos->boletoPercentual($modelBoleto->percentualJuros);
        $this->vlJuros = $basicos->boletoValor($modelBoleto->vlJuros);
        $this->qtdeDiasJuros = $modelBoleto->qtdeDiasJuros;
        $this->percentualMulta = $basicos->boletoPercentual($modelBoleto->percentualMulta);
        $this->vlMulta = $basicos->boletoValor($modelBoleto->vlMulta);
        $this->qtdeDiasMulta = $modelBoleto->qtdeDiasMulta;
        $this->percentualDesconto1 = $modelBoleto->percentualDesconto1;
        $this->vlDesconto1 = $modelBoleto->vlDesconto1;
        $this->dataLimiteDesconto1 = $modelBoleto->dataLimiteDesconto1;
        $this->percentualDesconto2 = $modelBoleto->percentualDesconto2;
        $this->vlDesconto2 = $modelBoleto->vlDesconto2;
        $this->dataLimiteDesconto2 = $modelBoleto->dataLimiteDesconto2;
        $this->percentualDesconto3 = $modelBoleto->percentualDesconto3;
        $this->vlDesconto3 = $modelBoleto->vlDesconto3;
        $this->dataLimiteDesconto3 = $modelBoleto->dataLimiteDesconto3;
        $this->prazoBonificacao = $modelBoleto->prazoBonificacao;
        $this->percentualBonificacao = $modelBoleto->percentualBonificacao;
        $this->vlBonificacao = $modelBoleto->vlBonificacao;
        $this->dtLimiteBonificacao = $modelBoleto->dtLimiteBonificacao;
        $this->vlAbatimento = $modelBoleto->vlAbatimento;
        $this->vlIOF = $modelBoleto->vlIOF;
        $this->nomePagador = $modelBoleto->nomePagador;
        $this->logradouroPagador = $modelBoleto->logradouroPagador;
        $this->nuLogradouroPagador = $modelBoleto->nuLogradouroPagador;
        $this->complementoLogradouroPagador = $modelBoleto->complementoLogradouroPagador;
        $this->cepPagador = $modelBoleto->cepPagador;
        $this->complementoCepPagador = $modelBoleto->complementoCepPagador;
        $this->bairroPagador = $modelBoleto->bairroPagador;
        $this->municipioPagador = $modelBoleto->municipioPagador;
        $this->ufPagador = $modelBoleto->ufPagador;
        $this->cdIndCpfcnpjPagador = $modelBoleto->cdIndCpfcnpjPagador;
        $this->nuCpfcnpjPagador = $modelBoleto->nuCpfcnpjPagador;
        $this->endEletronicoPagador = $modelBoleto->endEletronicoPagador;
        $this->nomeSacadorAvalista = $modelBoleto->nomeSacadorAvalista;
        $this->logradouroSacadorAvalista = $modelBoleto->logradouroSacadorAvalista;
        $this->nuLogradouroSacadorAvalista = $modelBoleto->nuLogradouroSacadorAvalista;
        $this->complementoLogradouroSacadorAvalista = $modelBoleto->complementoLogradouroSacadorAvalista;
        $this->cepSacadorAvalista = $modelBoleto->cepSacadorAvalista;
        $this->complementoCepSacadorAvalista = $modelBoleto->complementoCepSacadorAvalista;
        $this->bairroSacadorAvalista = $modelBoleto->bairroSacadorAvalista;
        $this->municipioSacadorAvalista = $modelBoleto->municipioSacadorAvalista;
        $this->ufSacadorAvalista = $modelBoleto->ufSacadorAvalista;
        $this->cdIndCpfcnpjSacadorAvalista = $modelBoleto->cdIndCpfcnpjSacadorAvalista;
        $this->nuCpfcnpjSacadorAvalista = $modelBoleto->nuCpfcnpjSacadorAvalista;
        $this->endEletronicoSacadorAvalista = $modelBoleto->endEletronicoSacadorAvalista;

        $dados = [
            "nuCPFCNPJ" => "$this->nuCPFCNPJ",
            "filialCPFCNPJ" => "$this->filialCPFCNPJ",
            "ctrlCPFCNPJ" => "$this->ctrlCPFCNPJ",
            "cdTipoAcesso" => "$this->cdTipoAcesso",
            "clubBanco" => "$this->clubBanco",
            "cdTipoContrato" => "$this->cdTipoContrato",
            "nuSequenciaContrato" => "$this->nuSequenciaContrato",
            "idProduto" => "$this->idProduto",
            "nuNegociacao" => "$this->nuNegociacao",
            "cdBanco" => "$this->cdBanco",
            "eNuSequenciaContrato" => "$this->eNuSequenciaContrato",
            "tpRegistro" => "$this->tpRegistro",
            "cdProduto" => "$this->cdProduto",
            "nuTitulo" => "$this->nuTitulo",
            "nuCliente" => "$this->nuCliente",
            "dtEmissaoTitulo" => "$this->dtEmissaoTitulo",
            "dtVencimentoTitulo" => "$this->dtVencimentoTitulo",
            "tpVencimento" => "$this->tpVencimento",
            "vlNominalTitulo" => "$this->vlNominalTitulo",
            "cdEspecieTitulo" => "$this->cdEspecieTitulo",
            "tpProtestoAutomaticoNegativacao" => "$this->tpProtestoAutomaticoNegativacao",
            "prazoProtestoAutomaticoNegativacao" => "$this->prazoProtestoAutomaticoNegativacao",
            "controleParticipante" => "$this->controleParticipante",
            "cdPagamentoParcial" => "$this->cdPagamentoParcial",
            "qtdePagamentoParcial" => "$this->qtdePagamentoParcial",
            "percentualJuros" => "$this->percentualJuros",
            "vlJuros" => "$this->vlJuros",
            "qtdeDiasJuros" => "$this->qtdeDiasJuros",
            "percentualMulta" => "$this->percentualMulta",
            "vlMulta" => "$this->vlMulta",
            "qtdeDiasMulta" => "$this->qtdeDiasMulta",
            "percentualDesconto1" => "$this->percentualDesconto1",
            "vlDesconto1" => "$this->vlDesconto1",
            "dataLimiteDesconto1" => "$this->dataLimiteDesconto1",
            "percentualDesconto2" => "$this->percentualDesconto2",
            "vlDesconto2" => "$this->vlDesconto2",
            "dataLimiteDesconto2" => "$this->dataLimiteDesconto2",
            "percentualDesconto3" => "$this->percentualDesconto3",
            "vlDesconto3" => "$this->vlDesconto3",
            "dataLimiteDesconto3" => "$this->dataLimiteDesconto3",
            "prazoBonificacao" => "$this->prazoBonificacao",
            "percentualBonificacao" => "$this->percentualBonificacao",
            "vlBonificacao" => "$this->vlBonificacao",
            "dtLimiteBonificacao" => "$this->dtLimiteBonificacao",
            "vlAbatimento" => "$this->vlAbatimento",
            "vlIOF" => "$this->vlIOF",
            "nomePagador" => "$this->nomePagador",
            "logradouroPagador" => "$this->logradouroPagador",
            "nuLogradouroPagador" => "$this->nuLogradouroPagador",
            "complementoLogradouroPagador" => "$this->complementoLogradouroPagador",
            "cepPagador" => "$this->cepPagador",
            "complementoCepPagador" => "$this->complementoCepPagador",
            "bairroPagador" => "$this->bairroPagador",
            "municipioPagador" => "$this->municipioPagador",
            "ufPagador" => "$this->ufPagador",
            "cdIndCpfcnpjPagador" => "$this->cdIndCpfcnpjPagador",
            "nuCpfcnpjPagador" => "$this->nuCpfcnpjPagador",
            "endEletronicoPagador" => "$this->endEletronicoPagador",
            "nomeSacadorAvalista" => "$this->nomeSacadorAvalista",
            "logradouroSacadorAvalista" => "$this->logradouroSacadorAvalista",
            "nuLogradouroSacadorAvalista" => "$this->nuLogradouroSacadorAvalista",
            "complementoLogradouroSacadorAvalista" => "$this->complementoLogradouroSacadorAvalista",
            "cepSacadorAvalista" => "$this->cepSacadorAvalista",
            "complementoCepSacadorAvalista" => "$this->complementoCepSacadorAvalista",
            "bairroSacadorAvalista" => "$this->bairroSacadorAvalista",
            "municipioSacadorAvalista" => "$this->municipioSacadorAvalista",
            "ufSacadorAvalista" => "$this->ufSacadorAvalista",
            "cdIndCpfcnpjSacadorAvalista" => "$this->cdIndCpfcnpjSacadorAvalista",
            "nuCpfcnpjSacadorAvalista" => "$this->nuCpfcnpjSacadorAvalista",
            "endEletronicoSacadorAvalista" => "$this->endEletronicoSacadorAvalista"
        ];

        $arquivo = '/var/www/html/Transportes/backend/web/boletos/' . Yii::$app->user->identity['cnpj'] . '/' . date('YmdHis') . '-Gerado.txt';
        file_put_contents($arquivo, json_encode($dados));

        if (is_file($arquivo)) {
            return $arquivo;
        } else {
            return false;
        }
    }

    public function assinaRemessa($file)
    {
        // Verifica se existe o arquivo
        if (!is_file($file)) {
            throw new HttpException('Arquivo não informado');
        }

        // Arquivo assinado
        $fileSign = '/var/www/html/Transportes/backend/web/boletos/' . Yii::$app->user->identity['cnpj'] . '/' . date('YmdHis') . '-Assinado.txt';

        // Certificado
        $certificado_pfx = file_get_contents($this->aConfig['pathCertsFiles'] . DIRECTORY_SEPARATOR . $this->aConfig['certPfxName']);

        // Verifica se o certificado é válido
        if (!openssl_pkcs12_read($certificado_pfx, $result, $this->aConfig['certPassword'])) {
            throw new HttpException(500, 'Não foi possível ler o certificado.');
        }

        // Lê conteúdo do certificado
        $certificado_key = openssl_x509_read($result['cert']);

        // Chave privada
        $private_key = openssl_pkey_get_private($result['pkey'], $this->aConfig['certPassword']);

        // Assina o arquivo
        openssl_pkcs7_sign(
            $file, $fileSign, $certificado_key, $private_key, [], PKCS7_BINARY | PKCS7_TEXT
        );

        // Conteúdo de assinatura
        $signature = file_get_contents($fileSign);
        $parts = preg_split("#\n\s*\n#Uis", $signature);
        $mensagem_assinada_base64 = $parts[1];

        return $mensagem_assinada_base64;
    }

    public function solicitaRegistro($fileSign, $modelBoleto, $ambiente = 'HOMOLOGACAO')
    {
        // URL do serviço
        $url = $this->urlServico[$ambiente];

        // Configurações curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fileSign);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Envia Arquivo
        $retorno = curl_exec($ch);

        // Verifica erro no envio
        if (curl_errno($ch)) {
            $info = curl_getinfo($ch);
            throw new Exception('Não foi possível registrar o boleto. ' . 'Erro:' . curl_errno($ch) . '.<br>' . $info);
        }

        // Cria DOM para retorno
        $doc = new DOMDocument();
        $doc->loadXML($retorno);

        // Transforma Retorno
        $retorno = $doc->getElementsByTagName('return')->item(0)->nodeValue;
        $retorno = preg_replace('/, }/i', '}', $retorno);
        $retorno = json_decode($retorno);

        // Verifica erro do serviço do Banco
        if (!empty($retorno->cdErro)) {
            throw new HttpException(500, 'Não foi possível registrar o boleto. Erro: ' . $retorno->msgErro);
        } else {

            $arquivo = '/var/www/html/Transportes/backend/web/boletos/' . Yii::$app->user->identity['cnpj'] . '/registrados/' . date('YmdHis') . '-Atendido.txt';
            file_put_contents($arquivo, json_encode($retorno));

            // Atualiza Status
            $this->atualizaStatus($modelBoleto, $arquivo);
        }

        // Retorna resposta
        return $retorno;
    }

    public function getRetorno($arquivo)
    {
        $conteudo = file_get_contents($arquivo);

        return json_decode($conteudo);
    }

    protected function atualizaStatus($modelBoleto, $arquivo)
    {
        // Status alterado para REGISTRADO
        $modelBoleto->status = 'REGISTRADO';

        // Arquivo registrado
        $modelBoleto->file = $arquivo;

        $modelBoleto->save();

        return true;
    }

}
