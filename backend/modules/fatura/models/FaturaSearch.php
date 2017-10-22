<?php

namespace backend\modules\fatura\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\fatura\models\Fatura;

/**
 * FaturaSearch represents the model behind the search form about `backend\modules\fatura\models\Fatura`.
 */
class FaturaSearch extends Fatura
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'numero'], 'integer'],
            [['criusu', 'cridt', 'dono', 'tipo', 'emissao', 'vencimento', 'observacoes', 'sacado', 'pagamento', 'status'], 'safe'],
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
        $query = Fatura::find();

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
            'numero' => $this->numero,
            'emissao' => $this->emissao,
            'vencimento' => $this->vencimento,
            'pagamento' => $this->pagamento,
        ]);

        $query->andFilterWhere(['like', 'criusu', $this->criusu])
            ->andFilterWhere(['like', 'dono', $this->dono])
            ->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'observacoes', $this->observacoes])
            ->andFilterWhere(['like', 'sacado', $this->sacado])
            ->andFilterWhere(['like', 'status', $this->status]);

        $query->orderBy('numero desc');

        return $dataProvider;
    }
}
