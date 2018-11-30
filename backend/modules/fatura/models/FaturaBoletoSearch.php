<?php

namespace backend\modules\fatura\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\fatura\models\FaturaBoleto;

/**
 * FaturaBoletoSearch represents the model behind the search form about `backend\modules\fatura\models\FaturaBoleto`.
 */
class FaturaBoletoSearch extends FaturaBoleto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fatura_id', 'cdTipoAcesso', 'cdTipoContrato', 'cdBanco', 'eNuSequenciaContrato', 'tpRegistro', 'cdProduto', 'tpVencimento', 'vlNominalTitulo', 'qtdePagamentoParcial', 'vlJuros', 'qtdeDiasJuros', 'vlMulta', 'qtdeDiasMulta', 'vlDesconto1', 'vlDesconto2', 'vlDesconto3', 'prazoBonificacao', 'vlBonificacao', 'vlAbatimento', 'vlIOF', 'cdIndCpfcnpjPagador', 'cdIndCpfcnpjSacadorAvalista'], 'integer'],
            [['nuCPFCNPJ', 'filialCPFCNPJ', 'ctrlCPFCNPJ', 'clubBanco', 'nuSequenciaContrato', 'idProduto', 'nuNegociacao', 'nuTitulo', 'nuCliente', 'dtEmissaoTitulo', 'dtVencimentoTitulo', 'cdEspecieTitulo', 'tpProtestoAutomaticoNegativacao', 'prazoProtestoAutomaticoNegativacao', 'controleParticipante', 'cdPagamentoParcial', 'percentualJuros', 'percentualMulta', 'percentualDesconto1', 'dataLimiteDesconto1', 'percentualDesconto2', 'dataLimiteDesconto2', 'percentualDesconto3', 'dataLimiteDesconto3', 'percentualBonificacao', 'dtLimiteBonificacao', 'nomePagador', 'logradouroPagador', 'nuLogradouroPagador', 'complementoLogradouroPagador', 'cepPagador', 'complementoCepPagador', 'bairroPagador', 'municipioPagador', 'ufPagador', 'nuCpfcnpjPagador', 'endEletronicoPagador', 'nomeSacadorAvalista', 'logradouroSacadorAvalista', 'nuLogradouroSacadorAvalista', 'complementoLogradouroSacadorAvalista', 'cepSacadorAvalista', 'complementoCepSacadorAvalista', 'bairroSacadorAvalista', 'municipioSacadorAvalista', 'ufSacadorAvalista', 'nuCpfcnpjSacadorAvalista', 'endEletronicoSacadorAvalista', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = FaturaBoleto::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fatura_id' => $this->fatura_id,
            'cdTipoAcesso' => $this->cdTipoAcesso,
            'cdTipoContrato' => $this->cdTipoContrato,
            'cdBanco' => $this->cdBanco,
            'eNuSequenciaContrato' => $this->eNuSequenciaContrato,
            'tpRegistro' => $this->tpRegistro,
            'cdProduto' => $this->cdProduto,
            'dtEmissaoTitulo' => $this->dtEmissaoTitulo,
            'dtVencimentoTitulo' => $this->dtVencimentoTitulo,
            'tpVencimento' => $this->tpVencimento,
            'vlNominalTitulo' => $this->vlNominalTitulo,
            'qtdePagamentoParcial' => $this->qtdePagamentoParcial,
            'vlJuros' => $this->vlJuros,
            'qtdeDiasJuros' => $this->qtdeDiasJuros,
            'vlMulta' => $this->vlMulta,
            'qtdeDiasMulta' => $this->qtdeDiasMulta,
            'vlDesconto1' => $this->vlDesconto1,
            'dataLimiteDesconto1' => $this->dataLimiteDesconto1,
            'vlDesconto2' => $this->vlDesconto2,
            'dataLimiteDesconto2' => $this->dataLimiteDesconto2,
            'vlDesconto3' => $this->vlDesconto3,
            'dataLimiteDesconto3' => $this->dataLimiteDesconto3,
            'prazoBonificacao' => $this->prazoBonificacao,
            'vlBonificacao' => $this->vlBonificacao,
            'dtLimiteBonificacao' => $this->dtLimiteBonificacao,
            'vlAbatimento' => $this->vlAbatimento,
            'vlIOF' => $this->vlIOF,
            'cdIndCpfcnpjPagador' => $this->cdIndCpfcnpjPagador,
            'cdIndCpfcnpjSacadorAvalista' => $this->cdIndCpfcnpjSacadorAvalista,
        ]);

        $query->andFilterWhere(['like', 'nuCPFCNPJ', $this->nuCPFCNPJ])
            ->andFilterWhere(['like', 'filialCPFCNPJ', $this->filialCPFCNPJ])
            ->andFilterWhere(['like', 'ctrlCPFCNPJ', $this->ctrlCPFCNPJ])
            ->andFilterWhere(['like', 'clubBanco', $this->clubBanco])
            ->andFilterWhere(['like', 'nuSequenciaContrato', $this->nuSequenciaContrato])
            ->andFilterWhere(['like', 'idProduto', $this->idProduto])
            ->andFilterWhere(['like', 'nuNegociacao', $this->nuNegociacao])
            ->andFilterWhere(['like', 'nuTitulo', $this->nuTitulo])
            ->andFilterWhere(['like', 'nuCliente', $this->nuCliente])
            ->andFilterWhere(['like', 'cdEspecieTitulo', $this->cdEspecieTitulo])
            ->andFilterWhere(['like', 'tpProtestoAutomaticoNegativacao', $this->tpProtestoAutomaticoNegativacao])
            ->andFilterWhere(['like', 'prazoProtestoAutomaticoNegativacao', $this->prazoProtestoAutomaticoNegativacao])
            ->andFilterWhere(['like', 'controleParticipante', $this->controleParticipante])
            ->andFilterWhere(['like', 'cdPagamentoParcial', $this->cdPagamentoParcial])
            ->andFilterWhere(['like', 'percentualJuros', $this->percentualJuros])
            ->andFilterWhere(['like', 'percentualMulta', $this->percentualMulta])
            ->andFilterWhere(['like', 'percentualDesconto1', $this->percentualDesconto1])
            ->andFilterWhere(['like', 'percentualDesconto2', $this->percentualDesconto2])
            ->andFilterWhere(['like', 'percentualDesconto3', $this->percentualDesconto3])
            ->andFilterWhere(['like', 'percentualBonificacao', $this->percentualBonificacao])
            ->andFilterWhere(['like', 'nomePagador', $this->nomePagador])
            ->andFilterWhere(['like', 'logradouroPagador', $this->logradouroPagador])
            ->andFilterWhere(['like', 'nuLogradouroPagador', $this->nuLogradouroPagador])
            ->andFilterWhere(['like', 'complementoLogradouroPagador', $this->complementoLogradouroPagador])
            ->andFilterWhere(['like', 'cepPagador', $this->cepPagador])
            ->andFilterWhere(['like', 'complementoCepPagador', $this->complementoCepPagador])
            ->andFilterWhere(['like', 'bairroPagador', $this->bairroPagador])
            ->andFilterWhere(['like', 'municipioPagador', $this->municipioPagador])
            ->andFilterWhere(['like', 'ufPagador', $this->ufPagador])
            ->andFilterWhere(['like', 'nuCpfcnpjPagador', $this->nuCpfcnpjPagador])
            ->andFilterWhere(['like', 'endEletronicoPagador', $this->endEletronicoPagador])
            ->andFilterWhere(['like', 'nomeSacadorAvalista', $this->nomeSacadorAvalista])
            ->andFilterWhere(['like', 'logradouroSacadorAvalista', $this->logradouroSacadorAvalista])
            ->andFilterWhere(['like', 'nuLogradouroSacadorAvalista', $this->nuLogradouroSacadorAvalista])
            ->andFilterWhere(['like', 'complementoLogradouroSacadorAvalista', $this->complementoLogradouroSacadorAvalista])
            ->andFilterWhere(['like', 'cepSacadorAvalista', $this->cepSacadorAvalista])
            ->andFilterWhere(['like', 'complementoCepSacadorAvalista', $this->complementoCepSacadorAvalista])
            ->andFilterWhere(['like', 'bairroSacadorAvalista', $this->bairroSacadorAvalista])
            ->andFilterWhere(['like', 'municipioSacadorAvalista', $this->municipioSacadorAvalista])
            ->andFilterWhere(['like', 'ufSacadorAvalista', $this->ufSacadorAvalista])
            ->andFilterWhere(['like', 'nuCpfcnpjSacadorAvalista', $this->nuCpfcnpjSacadorAvalista])
            ->andFilterWhere(['like', 'endEletronicoSacadorAvalista', $this->endEletronicoSacadorAvalista])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
