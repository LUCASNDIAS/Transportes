<?php

namespace backend\modules\mensagens\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\mensagens\models\Mensagens;

/**
 * MensagensSearch represents the model behind the search form about `backend\modules\mensagens\models\Mensagens`.
 */
class MensagensSearch extends Mensagens
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['data', 'para', 'titulo', 'mensagem', 'status', 'dataleitura', 'databaixa'], 'safe'],
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
        $query = Mensagens::find();

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
            'data' => $this->data,
            'dataleitura' => $this->dataleitura,
            'databaixa' => $this->databaixa,
        ]);

        $query->andFilterWhere(['like', 'para', $this->para])
            ->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'mensagem', $this->mensagem])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
