<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Tabelas;

/**
 * TabelasSearch represents the model behind the search form about `backend\models\Tabelas`.
 */
class TabelasSearch extends Tabelas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['cridt', 'criusu', 'dono', 'nome', 'descricao', 'fretevalor', 'despacho', 'seccat', 'itr', 'gris', 'pedagio', 'outros', 'valorminimo', 'pesominimo', 'excedente'], 'safe'],
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
        $query = Tabelas::find()->where(['dono' => Yii::$app->user->identity['cnpj']]);

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

        $query->andFilterWhere(['like', 'criusu', $this->criusu])
            ->andFilterWhere(['like', 'dono', $this->dono])
            ->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'descricao', $this->descricao])
            ->andFilterWhere(['like', 'fretevalor', $this->fretevalor])
            ->andFilterWhere(['like', 'despacho', $this->despacho])
            ->andFilterWhere(['like', 'seccat', $this->seccat])
            ->andFilterWhere(['like', 'itr', $this->itr])
            ->andFilterWhere(['like', 'gris', $this->gris])
            ->andFilterWhere(['like', 'pedagio', $this->pedagio])
            ->andFilterWhere(['like', 'outros', $this->outros])
            ->andFilterWhere(['like', 'valorminimo', $this->valorminimo])
            ->andFilterWhere(['like', 'pesominimo', $this->pesominimo])
            ->andFilterWhere(['like', 'excedente', $this->excedente]);

        return $dataProvider;
    }
}
