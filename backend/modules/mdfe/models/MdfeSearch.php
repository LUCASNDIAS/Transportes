<?php

namespace backend\modules\mdfe\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\mdfe\models\Mdfe;

/**
 * MdfeSearch represents the model behind the search form of `backend\modules\mdfe\models\Mdfe`.
 */
class MdfeSearch extends Mdfe
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'qtdecte', 'qtdenfe', 'qtdenf'], 'integer'],
            [['dono', 'cridt', 'criusu', 'chave', 'modelo', 'serie', 'numero', 'dtemissao', 'dtinicio', 'uf', 'tipoemitente', 'modalidade', 'formaemissao', 'ufcarga', 'ufdescarga', 'rntrc', 'ciot', 'placa', 'unidademedida', 'inffisco', 'infcontribuinte', 'status'], 'safe'],
            [['valormercadoria', 'pesomercadoria'], 'number'],
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
        $query = Mdfe::find()
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            //->andWhere(['ambiente' => '1'])
            ->andWhere(['NOT LIKE', 'status', 'DELETADO']);

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
            'ambiente' => $this->ambiente,
            'dtemissao' => $this->dtemissao,
            'dtinicio' => $this->dtinicio,
            'qtdecte' => $this->qtdecte,
            'qtdenfe' => $this->qtdenfe,
            'qtdenf' => $this->qtdenf,
            'valormercadoria' => $this->valormercadoria,
            'pesomercadoria' => $this->pesomercadoria,
        ]);

        $query->andFilterWhere(['like', 'dono', $this->dono])
            ->andFilterWhere(['like', 'criusu', $this->criusu])
            ->andFilterWhere(['like', 'chave', $this->chave])
            ->andFilterWhere(['like', 'modelo', $this->modelo])
            ->andFilterWhere(['like', 'serie', $this->serie])
            ->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'uf', $this->uf])
            ->andFilterWhere(['like', 'tipoemitente', $this->tipoemitente])
            ->andFilterWhere(['like', 'modalidade', $this->modalidade])
            ->andFilterWhere(['like', 'formaemissao', $this->formaemissao])
            ->andFilterWhere(['like', 'ufcarga', $this->ufcarga])
            ->andFilterWhere(['like', 'ufdescarga', $this->ufdescarga])
            ->andFilterWhere(['like', 'rntrc', $this->rntrc])
            ->andFilterWhere(['like', 'ciot', $this->ciot])
            ->andFilterWhere(['like', 'placa', $this->placa])
            ->andFilterWhere(['like', 'unidademedida', $this->unidademedida])
            ->andFilterWhere(['like', 'inffisco', $this->inffisco])
            ->andFilterWhere(['like', 'infcontribuinte', $this->infcontribuinte])
            ->andFilterWhere(['like', 'status', $this->status]);

        $query->orderBy('numero DESC');

        return $dataProvider;
    }
}
