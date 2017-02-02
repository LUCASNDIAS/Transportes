<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Clientes;

/**
 * ClientesSearch represents the model behind the search form about `backend\models\Clientes`.
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
            [['cridt', 'criusu', 'dono', 'nome', 'cnpj', 'ie', 'endrua', 'endnro', 'endbairro', 'endcid', 'enduf', 'endcep', 'responsaveis', 'telefones', 'emails', 'tabelas', 'status'], 'safe'],
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
        $query = Clientes::find()->where(['dono' => Yii::$app->user->identity['cnpj']]);

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
            ->andFilterWhere(['like', 'cnpj', $this->cnpj])
            ->andFilterWhere(['like', 'ie', $this->ie])
            ->andFilterWhere(['like', 'endrua', $this->endrua])
            ->andFilterWhere(['like', 'endnro', $this->endnro])
            ->andFilterWhere(['like', 'endbairro', $this->endbairro])
            ->andFilterWhere(['like', 'endcid', $this->endcid])
            ->andFilterWhere(['like', 'enduf', $this->enduf])
            ->andFilterWhere(['like', 'endcep', $this->endcep])
            ->andFilterWhere(['like', 'responsaveis', $this->responsaveis])
            ->andFilterWhere(['like', 'telefones', $this->telefones])
            ->andFilterWhere(['like', 'emails', $this->emails])
            ->andFilterWhere(['like', 'tabelas', $this->tabelas])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}