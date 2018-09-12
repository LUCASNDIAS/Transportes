<?php

namespace backend\modules\veiculos\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\veiculos\models\VeiculosAbastecimento;

/**
 * VeiculosAbastecimentoSearch represents the model behind the search form about `backend\modules\veiculos\models\VeiculosAbastecimento`.
 */
class VeiculosAbastecimentoSearch extends VeiculosAbastecimento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'veiculo', 'cheio'], 'integer'],
            [['odometro', 'valor_total', 'litros'], 'number'],
            [['data', 'combustivel', 'posto'], 'safe'],
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
        $query = VeiculosAbastecimento::find();

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
            'veiculo' => $this->veiculo,
            'odometro' => $this->odometro,
            'data' => $this->data,
            'cheio' => $this->cheio,
            'valor_total' => $this->valor_total,
            'litros' => $this->litros,
        ]);

        $query->andFilterWhere(['like', 'combustivel', $this->combustivel])
            ->andFilterWhere(['like', 'posto', $this->posto])
            ->andFilterWhere(['dono' => Yii::$app->user->identity['cnpj']]);

        return $dataProvider;
    }
}
