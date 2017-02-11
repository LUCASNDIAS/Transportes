<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Funcionarios;

/**
 * FuncionariosSearch represents the model behind the search form about `backend\models\Funcionarios`.
 */
class FuncionariosSearch extends Funcionarios
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nome', 'endrua', 'endbairro', 'endcep', 'endcid', 'enduf', 'naturalidade', 'datanascimento', 'pai', 'mae', 'tel1', 'tel2', 'radio', 'email', 'rg', 'cpf', 'cnhnum', 'cnhcat', 'cnhval', 'pis', 'cargo', 'salario', 'dtentrada', 'criusu', 'cridt', 'img'], 'safe'],
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
        $query = Funcionarios::find()->where(['dono' => Yii::$app->user->identity['cnpj']]);

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
            'datanascimento' => $this->datanascimento,
            'cnhval' => $this->cnhval,
            'dtentrada' => $this->dtentrada,
            'cridt' => $this->cridt,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'endrua', $this->endrua])
            ->andFilterWhere(['like', 'endbairro', $this->endbairro])
            ->andFilterWhere(['like', 'endcep', $this->endcep])
            ->andFilterWhere(['like', 'endcid', $this->endcid])
            ->andFilterWhere(['like', 'enduf', $this->enduf])
            ->andFilterWhere(['like', 'naturalidade', $this->naturalidade])
            ->andFilterWhere(['like', 'pai', $this->pai])
            ->andFilterWhere(['like', 'mae', $this->mae])
            ->andFilterWhere(['like', 'tel1', $this->tel1])
            ->andFilterWhere(['like', 'tel2', $this->tel2])
            ->andFilterWhere(['like', 'radio', $this->radio])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'rg', $this->rg])
            ->andFilterWhere(['like', 'cpf', $this->cpf])
            ->andFilterWhere(['like', 'cnhnum', $this->cnhnum])
            ->andFilterWhere(['like', 'cnhcat', $this->cnhcat])
            ->andFilterWhere(['like', 'pis', $this->pis])
            ->andFilterWhere(['like', 'cargo', $this->cargo])
            ->andFilterWhere(['like', 'salario', $this->salario])
            ->andFilterWhere(['like', 'criusu', $this->criusu])
            ->andFilterWhere(['like', 'img', $this->img]);

        return $dataProvider;
    }
}
