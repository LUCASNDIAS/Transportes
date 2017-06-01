<?php

namespace backend\modules\clientes\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\clientes\models\Clientes;

/**
 * ClientesSearch represents the model behind the search form of `backend\modules\clientes\models\Clientes`.
 */
class ClientesSearch extends Clientes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['cridt', 'criusu', 'dono', 'nome', 'cnpj', 'ie', 'endrua', 'endnro', 'endbairro', 'endcid', 'enduf', 'endcep', 'status'], 'safe'],
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
        $query = Clientes::find();

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
        ]);

        $query->andFilterWhere(['dono' => Yii::$app->user->identity['cnpj']])
            ->andFilterWhere(['like', 'criusu', $this->criusu])
            ->andFilterWhere(['like', 'dono', $this->dono])
            ->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'cnpj', $this->cnpj])
            ->andFilterWhere(['like', 'ie', $this->ie])
            ->andFilterWhere(['like', 'endrua', $this->endrua])
            ->andFilterWhere(['like', 'endnro', $this->endnro])
            ->andFilterWhere(['like', 'endbairro', $this->endbairro])
            ->andFilterWhere(['like', 'endcid', $this->endcid])
            ->andFilterWhere(['like', 'enduf', $this->enduf])
            ->andFilterWhere(['like', 'endcep', $this->endcep])
            ->andFilterWhere(['like', 'status', $this->status]);


        return $dataProvider;
    }
}
