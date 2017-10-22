<?php

namespace backend\modules\financeiro\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\financeiro\models\Financeiro;

/**
 * FinanceiroSearch represents the model behind the search form about `backend\modules\financeiro\models\Financeiro`.
 */
class FinanceiroSearch extends Financeiro
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fatura'], 'integer'],
            [['criusu', 'cridt', 'dono', 'nome', 'descricao', 'emissao', 'vencimento', 'observacoes', 'cpgto', 'dtpgto', 'sacado', 'status'], 'safe'],
            [['valor'], 'number'],
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
    public function search($params, $t = 'A')
    {
        $query = Financeiro::find();

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
            'emissao' => $this->emissao,
            'vencimento' => $this->vencimento,
            'valor' => $this->valor,
            'dtpgto' => $this->dtpgto,
            'fatura' => $this->fatura,
            'tipo' => $t,
        ]);

        $query->andFilterWhere(['dono' => Yii::$app->user->identity['cnpj']])
            ->andFilterWhere(['like', 'criusu', $this->criusu])
            ->andFilterWhere(['like', 'dono', $this->dono])
            ->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'descricao', $this->descricao])
            ->andFilterWhere(['like', 'observacoes', $this->observacoes])
            ->andFilterWhere(['like', 'cpgto', $this->cpgto])
            ->andFilterWhere(['like', 'sacado', $this->sacado])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
