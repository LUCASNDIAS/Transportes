<?php

namespace backend\modules\veiculos\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\veiculos\models\VeiculosServico;

/**
 * VeiculosServicoSearch represents the model behind the search form about `backend\modules\veiculos\models\VeiculosServico`.
 */
class VeiculosServicoSearch extends VeiculosServico
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'veiculo', 'tipo_servico', 'parcelas'], 'integer'],
            [['cridt', 'criusu', 'dono', 'data', 'prox_data', 'local', 'detalhes', 'observacoes'], 'safe'],
            [['odometro', 'valor_total', 'prox_odometro'], 'number'],
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
        $query = VeiculosServico::find();

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
            'veiculo' => $this->veiculo,
            'odometro' => $this->odometro,
            'data' => $this->data,
            'tipo_servico' => $this->tipo_servico,
            'valor_total' => $this->valor_total,
            'parcelas' => $this->parcelas,
            'prox_odometro' => $this->prox_odometro,
            'prox_data' => $this->prox_data,
        ]);

        $query->andFilterWhere(['like', 'criusu', $this->criusu])
            ->andFilterWhere(['like', 'dono', $this->dono])
            ->andFilterWhere(['like', 'local', $this->local])
            ->andFilterWhere(['like', 'detalhes', $this->detalhes])
            ->andFilterWhere(['like', 'observacoes', $this->observacoes]);

        return $dataProvider;
    }
}
