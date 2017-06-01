<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cte;

/**
 * CteSearch represents the model behind the search form of `backend\models\Cte`.
 */
class CteSearch extends Cte
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'infCTe_chave', 'infCTe_versao', 'ide_cDV', 'ide_tpAmb', 'ide_refCTe', 'ide_cMunIni', 'infNFe'], 'integer'],
            [['cridt', 'criusu', 'dono', 'ide_cUF', 'ide_cCT', 'ide_CFOP', 'ide_natOp', 'ide_forPag', 'ide_mod', 'ide_serie', 'ide_nCT', 'ide_dhEmi', 'ide_tpImp', 'ide_tpEmis', 'ide_tpCTe', 'ide_procEmi', 'ide_verProc', 'ide_cMunEnv', 'ide_xMunEnv', 'ide_UFEnv', 'ide_modal', 'ide_tpServ', 'ide_xMunIni', 'ide_UFIni', 'ide_cMunFim', 'ide_xMunFim', 'ide_UFFim', 'ide_retira', 'ide_xDetRetira', 'ide_dhCont', 'ide_xJust', 'toma', 'tomador', 'emitente', 'remetente', 'destinatario', 'comp_xNome', 'icms', 'infQ_cUnid', 'infQ_tpMed', 'infNF', 'seguro', 'infModal_versaoModal', 'rodo', 'veiculo', 'motorista', 'pathXML', 'pathPDF', 'entrega_data', 'entrega_hora', 'entrega_nome', 'entrega_doc', 'status'], 'safe'],
            [['vPrest_vTPrest', 'vPrest_vRec', 'comp_vComp', 'infCarga', 'infQ_qCarga'], 'number'],
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
        $query = Cte::find();

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
            'cridt' => $this->cridt,
            'infCTe_chave' => $this->infCTe_chave,
            'infCTe_versao' => $this->infCTe_versao,
            'ide_dhEmi' => $this->ide_dhEmi,
            'ide_cDV' => $this->ide_cDV,
            'ide_tpAmb' => $this->ide_tpAmb,
            'ide_refCTe' => $this->ide_refCTe,
            'ide_cMunIni' => $this->ide_cMunIni,
            'ide_dhCont' => $this->ide_dhCont,
            'vPrest_vTPrest' => $this->vPrest_vTPrest,
            'vPrest_vRec' => $this->vPrest_vRec,
            'comp_vComp' => $this->comp_vComp,
            'infCarga' => $this->infCarga,
            'infQ_qCarga' => $this->infQ_qCarga,
            'infNFe' => $this->infNFe,
            'entrega_data' => $this->entrega_data,
        ]);

        $query->andFilterWhere(['like', 'criusu', $this->criusu])
            ->andFilterWhere(['like', 'dono', $this->dono])
            ->andFilterWhere(['like', 'ide_cUF', $this->ide_cUF])
            ->andFilterWhere(['like', 'ide_cCT', $this->ide_cCT])
            ->andFilterWhere(['like', 'ide_CFOP', $this->ide_CFOP])
            ->andFilterWhere(['like', 'ide_natOp', $this->ide_natOp])
            ->andFilterWhere(['like', 'ide_forPag', $this->ide_forPag])
            ->andFilterWhere(['like', 'ide_mod', $this->ide_mod])
            ->andFilterWhere(['like', 'ide_serie', $this->ide_serie])
            ->andFilterWhere(['like', 'ide_nCT', $this->ide_nCT])
            ->andFilterWhere(['like', 'ide_tpImp', $this->ide_tpImp])
            ->andFilterWhere(['like', 'ide_tpEmis', $this->ide_tpEmis])
            ->andFilterWhere(['like', 'ide_tpCTe', $this->ide_tpCTe])
            ->andFilterWhere(['like', 'ide_procEmi', $this->ide_procEmi])
            ->andFilterWhere(['like', 'ide_verProc', $this->ide_verProc])
            ->andFilterWhere(['like', 'ide_cMunEnv', $this->ide_cMunEnv])
            ->andFilterWhere(['like', 'ide_xMunEnv', $this->ide_xMunEnv])
            ->andFilterWhere(['like', 'ide_UFEnv', $this->ide_UFEnv])
            ->andFilterWhere(['like', 'ide_modal', $this->ide_modal])
            ->andFilterWhere(['like', 'ide_tpServ', $this->ide_tpServ])
            ->andFilterWhere(['like', 'ide_xMunIni', $this->ide_xMunIni])
            ->andFilterWhere(['like', 'ide_UFIni', $this->ide_UFIni])
            ->andFilterWhere(['like', 'ide_cMunFim', $this->ide_cMunFim])
            ->andFilterWhere(['like', 'ide_xMunFim', $this->ide_xMunFim])
            ->andFilterWhere(['like', 'ide_UFFim', $this->ide_UFFim])
            ->andFilterWhere(['like', 'ide_retira', $this->ide_retira])
            ->andFilterWhere(['like', 'ide_xDetRetira', $this->ide_xDetRetira])
            ->andFilterWhere(['like', 'ide_xJust', $this->ide_xJust])
            ->andFilterWhere(['like', 'toma', $this->toma])
            ->andFilterWhere(['like', 'tomador', $this->tomador])
            ->andFilterWhere(['like', 'emitente', $this->emitente])
            ->andFilterWhere(['like', 'remetente', $this->remetente])
            ->andFilterWhere(['like', 'destinatario', $this->destinatario])
            ->andFilterWhere(['like', 'comp_xNome', $this->comp_xNome])
            ->andFilterWhere(['like', 'icms', $this->icms])
            ->andFilterWhere(['like', 'infQ_cUnid', $this->infQ_cUnid])
            ->andFilterWhere(['like', 'infQ_tpMed', $this->infQ_tpMed])
            ->andFilterWhere(['like', 'infNF', $this->infNF])
            ->andFilterWhere(['like', 'seguro', $this->seguro])
            ->andFilterWhere(['like', 'infModal_versaoModal', $this->infModal_versaoModal])
            ->andFilterWhere(['like', 'rodo', $this->rodo])
            ->andFilterWhere(['like', 'veiculo', $this->veiculo])
            ->andFilterWhere(['like', 'motorista', $this->motorista])
            ->andFilterWhere(['like', 'pathXML', $this->pathXML])
            ->andFilterWhere(['like', 'pathPDF', $this->pathPDF])
            ->andFilterWhere(['like', 'entrega_hora', $this->entrega_hora])
            ->andFilterWhere(['like', 'entrega_nome', $this->entrega_nome])
            ->andFilterWhere(['like', 'entrega_doc', $this->entrega_doc])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
