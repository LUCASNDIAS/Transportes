<?php

namespace backend\modules\seguro\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\seguro\models\Seguro;

/**
 * SeguroSearch represents the model behind the search form about `backend\modules\seguro\models\Seguro`.
 */
class SeguroSearch extends Seguro
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['dono', 'cridt', 'criusu', 'xseg', 'cnpj', 'napol', 'naver'], 'safe'],
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
        $query = Seguro::find();

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

        $query->andFilterWhere(['like', 'dono', Yii::$app->user->identity['cnpj']])
            ->andFilterWhere(['like', 'criusu', $this->criusu])
            ->andFilterWhere(['like', 'criusu', $this->criusu])
            ->andFilterWhere(['like', 'xseg', $this->xseg])
            ->andFilterWhere(['like', 'cnpj', $this->cnpj])
            ->andFilterWhere(['like', 'napol', $this->napol])
            ->andFilterWhere(['like', 'naver', $this->naver]);

        return $dataProvider;
    }
}
