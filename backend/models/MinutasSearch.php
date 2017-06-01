<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Minutas;

/**
 * MinutasSearch represents the model behind the search form about `backend\models\Minutas`.
 */
class MinutasSearch extends Minutas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'baixamanifesto', 'baixacoleta', 'baixaentrega', 'baixafatura', 'baixapagamento'], 'integer'],
            [['cridt', 'criusu', 'dono', 'numero', 'tipofrete', 'entregalocal', 'pagadorenvolvido', 'pagadorcnpj', 'formapagamento', 'remetente', 'destinatario', 'consignatario', 'notasnumero', 'notasvalor', 'notaspeso', 'notasvolumes', 'notasdimensoes', 'pesoreal', 'pesocubado', 'fretevalor', 'fretepeso', 'taxacoleta', 'taxaentrega', 'taxaseguro', 'taxagris', 'taxadespacho', 'taxaitr', 'taxaextra', 'taxaseccat', 'taxapedagio', 'taxaoutros', 'taxafretevalor', 'desconto', 'fretetotal', 'naturezacarga', 'status', 'manifesto', 'coletadata', 'coletahora', 'coletanome', 'coletaplaca', 'entregadata', 'entregahora', 'entreganome', 'entregadoc', 'fatura', 'pagamentorecibo', 'pagamentodata', 'tabela', 'observacoes'], 'safe'],
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
        $query = Minutas::find()->where(['dono' => Yii::$app->user->identity['cnpj']]);

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
            'baixamanifesto' => $this->baixamanifesto,
            'baixacoleta' => $this->baixacoleta,
            'coletadata' => $this->coletadata,
            'baixaentrega' => $this->baixaentrega,
            'entregadata' => $this->entregadata,
            'baixafatura' => $this->baixafatura,
            'baixapagamento' => $this->baixapagamento,
            'pagamentodata' => $this->pagamentodata,
        ]);

        $query->andFilterWhere(['like', 'criusu', $this->criusu])
            ->andFilterWhere(['like', 'dono', $this->dono])
            ->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'tipofrete', $this->tipofrete])
            ->andFilterWhere(['like', 'entregalocal', $this->entregalocal])
            ->andFilterWhere(['like', 'pagadorenvolvido', $this->pagadorenvolvido])
            ->andFilterWhere(['like', 'pagadorcnpj', $this->pagadorcnpj])
            ->andFilterWhere(['like', 'formapagamento', $this->formapagamento])
            ->andFilterWhere(['like', 'remetente', $this->remetente])
            ->andFilterWhere(['like', 'destinatario', $this->destinatario])
            ->andFilterWhere(['like', 'consignatario', $this->consignatario])
            ->andFilterWhere(['like', 'notasnumero', $this->notasnumero])
            ->andFilterWhere(['like', 'notasvalor', $this->notasvalor])
            ->andFilterWhere(['like', 'notaspeso', $this->notaspeso])
            ->andFilterWhere(['like', 'notasvolumes', $this->notasvolumes])
            ->andFilterWhere(['like', 'notasdimensoes', $this->notasdimensoes])
            ->andFilterWhere(['like', 'pesoreal', $this->pesoreal])
            ->andFilterWhere(['like', 'pesocubado', $this->pesocubado])
            ->andFilterWhere(['like', 'fretevalor', $this->fretevalor])
            ->andFilterWhere(['like', 'fretepeso', $this->fretepeso])
            ->andFilterWhere(['like', 'taxacoleta', $this->taxacoleta])
            ->andFilterWhere(['like', 'taxaentrega', $this->taxaentrega])
            ->andFilterWhere(['like', 'taxaseguro', $this->taxaseguro])
            ->andFilterWhere(['like', 'taxagris', $this->taxagris])
            ->andFilterWhere(['like', 'taxadespacho', $this->taxadespacho])
            ->andFilterWhere(['like', 'taxaitr', $this->taxaitr])
            ->andFilterWhere(['like', 'taxaextra', $this->taxaextra])
            ->andFilterWhere(['like', 'taxaseccat', $this->taxaseccat])
            ->andFilterWhere(['like', 'taxapedagio', $this->taxapedagio])
            ->andFilterWhere(['like', 'taxaoutros', $this->taxaoutros])
            ->andFilterWhere(['like', 'taxafretevalor', $this->taxafretevalor])
            ->andFilterWhere(['like', 'desconto', $this->desconto])
            ->andFilterWhere(['like', 'fretetotal', $this->fretetotal])
            ->andFilterWhere(['like', 'naturezacarga', $this->naturezacarga])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'manifesto', $this->manifesto])
            ->andFilterWhere(['like', 'coletahora', $this->coletahora])
            ->andFilterWhere(['like', 'coletanome', $this->coletanome])
            ->andFilterWhere(['like', 'coletaplaca', $this->coletaplaca])
            ->andFilterWhere(['like', 'entregahora', $this->entregahora])
            ->andFilterWhere(['like', 'entreganome', $this->entreganome])
            ->andFilterWhere(['like', 'entregadoc', $this->entregadoc])
            ->andFilterWhere(['like', 'fatura', $this->fatura])
            ->andFilterWhere(['like', 'pagamentorecibo', $this->pagamentorecibo])
            ->andFilterWhere(['like', 'tabela', $this->tabela])
            ->andFilterWhere(['like', 'observacoes', $this->observacoes]);
        
        $query->orderBy('id DESC');

        return $dataProvider;
    }
}
