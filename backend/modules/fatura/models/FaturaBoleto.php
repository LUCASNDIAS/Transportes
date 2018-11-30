<?php

namespace backend\modules\fatura\models;

use Yii;

/**
 * This is the model class for table "fatura_boleto".
 *
 * @property integer $id
 * @property integer $fatura_id
 * @property string $nuCPFCNPJ
 * @property string $filialCPFCNPJ
 * @property string $ctrlCPFCNPJ
 * @property integer $cdTipoAcesso
 * @property string $clubBanco
 * @property integer $cdTipoContrato
 * @property string $nuSequenciaContrato
 * @property string $idProduto
 * @property string $nuNegociacao
 * @property integer $cdBanco
 * @property integer $eNuSequenciaContrato
 * @property integer $tpRegistro
 * @property integer $cdProduto
 * @property string $nuTitulo
 * @property string $nuCliente
 * @property string $dtEmissaoTitulo
 * @property string $dtVencimentoTitulo
 * @property integer $tpVencimento
 * @property integer $vlNominalTitulo
 * @property string $cdEspecieTitulo
 * @property string $tpProtestoAutomaticoNegativacao
 * @property string $prazoProtestoAutomaticoNegativacao
 * @property string $controleParticipante
 * @property string $cdPagamentoParcial
 * @property integer $qtdePagamentoParcial
 * @property string $percentualJuros
 * @property integer $vlJuros
 * @property integer $qtdeDiasJuros
 * @property string $percentualMulta
 * @property integer $vlMulta
 * @property integer $qtdeDiasMulta
 * @property string $percentualDesconto1
 * @property integer $vlDesconto1
 * @property string $dataLimiteDesconto1
 * @property string $percentualDesconto2
 * @property integer $vlDesconto2
 * @property string $dataLimiteDesconto2
 * @property string $percentualDesconto3
 * @property integer $vlDesconto3
 * @property string $dataLimiteDesconto3
 * @property integer $prazoBonificacao
 * @property string $percentualBonificacao
 * @property integer $vlBonificacao
 * @property string $dtLimiteBonificacao
 * @property integer $vlAbatimento
 * @property integer $vlIOF
 * @property string $nomePagador
 * @property string $logradouroPagador
 * @property string $nuLogradouroPagador
 * @property string $complementoLogradouroPagador
 * @property string $cepPagador
 * @property string $complementoCepPagador
 * @property string $bairroPagador
 * @property string $municipioPagador
 * @property string $ufPagador
 * @property integer $cdIndCpfcnpjPagador
 * @property string $nuCpfcnpjPagador
 * @property string $endEletronicoPagador
 * @property string $nomeSacadorAvalista
 * @property string $logradouroSacadorAvalista
 * @property string $nuLogradouroSacadorAvalista
 * @property string $complementoLogradouroSacadorAvalista
 * @property string $cepSacadorAvalista
 * @property string $complementoCepSacadorAvalista
 * @property string $bairroSacadorAvalista
 * @property string $municipioSacadorAvalista
 * @property string $ufSacadorAvalista
 * @property integer $cdIndCpfcnpjSacadorAvalista
 * @property string $nuCpfcnpjSacadorAvalista
 * @property string $endEletronicoSacadorAvalista
 * @property string $file
 * @property string $status
 */
class FaturaBoleto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fatura_boleto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nuCliente', 'dtEmissaoTitulo', 'dtVencimentoTitulo', 'vlNominalTitulo', 'cdEspecieTitulo', 'status',
                'nomePagador', 'logradouroPagador', 'nuLogradouroPagador', 'cepPagador', 'complementoCepPagador',
                'bairroPagador', 'ufPagador'], 'required'],
            [['fatura_id', 'cdTipoAcesso', 'cdTipoContrato', 'cdBanco', 'eNuSequenciaContrato', 'tpRegistro', 'cdProduto', 'tpVencimento', 'qtdePagamentoParcial', 'qtdeDiasJuros', 'qtdeDiasMulta', 'vlDesconto1', 'vlDesconto2', 'vlDesconto3', 'prazoBonificacao', 'vlBonificacao', 'vlAbatimento', 'vlIOF', 'cdIndCpfcnpjPagador', 'cdIndCpfcnpjSacadorAvalista'], 'integer'],
            [['dtEmissaoTitulo', 'dtVencimentoTitulo'], 'safe'],
            [['vlNominalTitulo', 'vlJuros', 'vlMulta'], 'number'],
            [['nuCPFCNPJ'], 'string', 'max' => 9],
            [['filialCPFCNPJ'], 'string', 'max' => 4],
            [['ctrlCPFCNPJ', 'idProduto', 'cdEspecieTitulo', 'tpProtestoAutomaticoNegativacao', 'prazoProtestoAutomaticoNegativacao', 'ufPagador', 'ufSacadorAvalista'], 'string', 'max' => 2],
            [['clubBanco', 'nuSequenciaContrato', 'nuCliente', 'nuLogradouroPagador', 'nuLogradouroSacadorAvalista',
                'dataLimiteDesconto1', 'dataLimiteDesconto2', 'dataLimiteDesconto3', 'dtLimiteBonificacao'], 'string', 'max' => 10],
            [['nuNegociacao'], 'string', 'max' => 18],
            [['nuTitulo'], 'string', 'max' => 11],
            [['controleParticipante'], 'string', 'max' => 25],
            [['cdPagamentoParcial'], 'string', 'max' => 1],
            [['percentualJuros', 'percentualMulta', 'percentualDesconto1', 'percentualDesconto2', 'percentualDesconto3', 'percentualBonificacao'], 'string', 'max' => 8],
            [['nomePagador', 'endEletronicoPagador', 'endEletronicoSacadorAvalista'], 'string', 'max' => 70],
            [['logradouroPagador', 'bairroPagador', 'nomeSacadorAvalista', 'logradouroSacadorAvalista', 'bairroSacadorAvalista', 'municipioSacadorAvalista'], 'string', 'max' => 40],
            [['complementoLogradouroPagador', 'complementoLogradouroSacadorAvalista'], 'string', 'max' => 15],
            [['cepPagador', 'cepSacadorAvalista'], 'string', 'max' => 5],
            [['complementoCepPagador', 'complementoCepSacadorAvalista'], 'string', 'max' => 3],
            [['municipioPagador'], 'string', 'max' => 30],
            [['nuCpfcnpjPagador', 'nuCpfcnpjSacadorAvalista'], 'string', 'max' => 14],
            [['status'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fatura_id' => Yii::t('app', 'Fatura ID'),
            'nuCPFCNPJ' => Yii::t('app', 'Nu Cpfcnpj'),
            'filialCPFCNPJ' => Yii::t('app', 'Filial Cpfcnpj'),
            'ctrlCPFCNPJ' => Yii::t('app', 'Ctrl Cpfcnpj'),
            'cdTipoAcesso' => Yii::t('app', 'Cd Tipo Acesso'),
            'clubBanco' => Yii::t('app', 'Club Banco'),
            'cdTipoContrato' => Yii::t('app', 'Cd Tipo Contrato'),
            'nuSequenciaContrato' => Yii::t('app', 'Nu Sequencia Contrato'),
            'idProduto' => Yii::t('app', 'Id Produto'),
            'nuNegociacao' => Yii::t('app', 'Nu Negociacao'),
            'cdBanco' => Yii::t('app', 'Cd Banco'),
            'eNuSequenciaContrato' => Yii::t('app', 'E Nu Sequencia Contrato'),
            'tpRegistro' => Yii::t('app', 'Tp Registro'),
            'cdProduto' => Yii::t('app', 'Carteira'),
            'nuTitulo' => Yii::t('app', 'Nu Titulo'),
            'nuCliente' => Yii::t('app', 'Identificador'),
            'dtEmissaoTitulo' => Yii::t('app', 'Data Emissão'),
            'dtVencimentoTitulo' => Yii::t('app', 'Data Vencimento'),
            'tpVencimento' => Yii::t('app', 'Tp Vencimento'),
            'vlNominalTitulo' => Yii::t('app', 'R$ Nominal'),
            'cdEspecieTitulo' => Yii::t('app', 'Espécie do Título'),
            'tpProtestoAutomaticoNegativacao' => Yii::t('app', 'Tp Protesto Automatico Negativacao'),
            'prazoProtestoAutomaticoNegativacao' => Yii::t('app', 'Prazo Protesto Automatico Negativacao'),
            'controleParticipante' => Yii::t('app', 'Controle Participante'),
            'cdPagamentoParcial' => Yii::t('app', 'Cd Pagamento Parcial'),
            'qtdePagamentoParcial' => Yii::t('app', 'Qtde Pagamento Parcial'),
            'percentualJuros' => Yii::t('app', '% Juros'),
            'vlJuros' => Yii::t('app', 'R$ Juros'),
            'qtdeDiasJuros' => Yii::t('app', 'Dias Juros'),
            'percentualMulta' => Yii::t('app', '% Multa'),
            'vlMulta' => Yii::t('app', 'R$ Multa'),
            'qtdeDiasMulta' => Yii::t('app', 'Dias Multa'),
            'percentualDesconto1' => Yii::t('app', 'Percentual Desconto1'),
            'vlDesconto1' => Yii::t('app', 'Vl Desconto1'),
            'dataLimiteDesconto1' => Yii::t('app', 'Data Limite Desconto1'),
            'percentualDesconto2' => Yii::t('app', 'Percentual Desconto2'),
            'vlDesconto2' => Yii::t('app', 'Vl Desconto2'),
            'dataLimiteDesconto2' => Yii::t('app', 'Data Limite Desconto2'),
            'percentualDesconto3' => Yii::t('app', 'Percentual Desconto3'),
            'vlDesconto3' => Yii::t('app', 'Vl Desconto3'),
            'dataLimiteDesconto3' => Yii::t('app', 'Data Limite Desconto3'),
            'prazoBonificacao' => Yii::t('app', 'Prazo Bonificacao'),
            'percentualBonificacao' => Yii::t('app', 'Percentual Bonificacao'),
            'vlBonificacao' => Yii::t('app', 'Vl Bonificacao'),
            'dtLimiteBonificacao' => Yii::t('app', 'Dt Limite Bonificacao'),
            'vlAbatimento' => Yii::t('app', 'Vl Abatimento'),
            'vlIOF' => Yii::t('app', 'Vl Iof'),
            'nomePagador' => Yii::t('app', 'Nome Pagador'),
            'logradouroPagador' => Yii::t('app', 'Endereço'),
            'nuLogradouroPagador' => Yii::t('app', 'Nro'),
            'complementoLogradouroPagador' => Yii::t('app', 'Complemento'),
            'cepPagador' => Yii::t('app', 'CEP'),
            'complementoCepPagador' => Yii::t('app', 'Cpl CEP'),
            'bairroPagador' => Yii::t('app', 'Bairro'),
            'municipioPagador' => Yii::t('app', 'Município'),
            'ufPagador' => Yii::t('app', 'UF'),
            'cdIndCpfcnpjPagador' => Yii::t('app', 'Cd Ind Cpfcnpj Pagador'),
            'nuCpfcnpjPagador' => Yii::t('app', 'CPF / CNPJ'),
            'endEletronicoPagador' => Yii::t('app', 'E-mail'),
            'nomeSacadorAvalista' => Yii::t('app', 'Nome Sacador Avalista'),
            'logradouroSacadorAvalista' => Yii::t('app', 'Logradouro Sacador Avalista'),
            'nuLogradouroSacadorAvalista' => Yii::t('app', 'Nu Logradouro Sacador Avalista'),
            'complementoLogradouroSacadorAvalista' => Yii::t('app', 'Complemento Logradouro Sacador Avalista'),
            'cepSacadorAvalista' => Yii::t('app', 'Cep Sacador Avalista'),
            'complementoCepSacadorAvalista' => Yii::t('app', 'Complemento Cep Sacador Avalista'),
            'bairroSacadorAvalista' => Yii::t('app', 'Bairro Sacador Avalista'),
            'municipioSacadorAvalista' => Yii::t('app', 'Municipio Sacador Avalista'),
            'ufSacadorAvalista' => Yii::t('app', 'Uf Sacador Avalista'),
            'cdIndCpfcnpjSacadorAvalista' => Yii::t('app', 'Cd Ind Cpfcnpj Sacador Avalista'),
            'nuCpfcnpjSacadorAvalista' => Yii::t('app', 'Nu Cpfcnpj Sacador Avalista'),
            'endEletronicoSacadorAvalista' => Yii::t('app', 'End Eletronico Sacador Avalista'),
            'file' => Yii::t('app', 'File'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return FaturaBoletoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FaturaBoletoQuery(get_called_class());
    }
}
