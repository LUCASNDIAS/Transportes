<?php

namespace backend\modules\veiculos\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\veiculos\models\Veiculos;

/**
 * VeiculosSearch represents the model behind the search form of `backend\modules\veiculos\models\Veiculos`.
 */
class VeiculosSearch extends Veiculos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tpveic_id', 'tprod_id', 'tpcar_id'], 'integer'],
            [['marca', 'modelo', 'cint', 'renavam', 'placa', 'tara', 'capkg', 'capm3', 'tpprop', 'uf'], 'safe'],
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
        $query = Veiculos::find();

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
            'tpveic_id' => $this->tpveic_id,
            'tprod_id' => $this->tprod_id,
            'tpcar_id' => $this->tpcar_id,
        ]);

        $query->andFilterWhere(['like', 'marca', $this->marca])
            ->andFilterWhere(['like', 'modelo', $this->modelo])
            ->andFilterWhere(['like', 'cint', $this->cint])
            ->andFilterWhere(['like', 'renavam', $this->renavam])
            ->andFilterWhere(['like', 'placa', $this->placa])
            ->andFilterWhere(['like', 'tara', $this->tara])
            ->andFilterWhere(['like', 'capkg', $this->capkg])
            ->andFilterWhere(['like', 'capm3', $this->capm3])
            ->andFilterWhere(['like', 'tpprop', $this->tpprop])
            ->andFilterWhere(['like', 'uf', $this->uf]);

        return $dataProvider;
    }
}
