<?php

namespace backend\modules\cte\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\cte\models\Cte;

/**
 * CteSearch represents the model behind the search form of `backend\modules\cte\models\Cte`.
 */
class CteSearch extends Cte
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ambiente', 'forpag', 'tpemis', 'tpcte', 'tpserv', 'retira', 'toma', 'outrauf', 'respseg', 'lota'], 'integer'],
            [['dono', 'cridt', 'criusu', 'chave', 'modelo', 'serie', 'numero', 'dtemissao', 'cct', 'cfop', 'natop', 'refcte', 'cmunenv', 'xmunenv', 'ufenv', 'modal', 'cmunini', 'xmunini', 'ufini', 'cmunfim', 'xmunfim', 'uffim', 'xdetretira', 'dhcont', 'xjust', 'tomador', 'remetente', 'destinatario', 'recebedor', 'expedidor', 'cst', 'prodpred', 'xoutcat', 'xseg', 'napol', 'rntrc', 'dprev', 'status'], 'safe'],
            [['vtprest', 'vrec', 'predbc', 'vbc', 'picms', 'vicms', 'vbcstret', 'vicmsret', 'picmsret', 'vcred', 'vtottrib', 'vcarga'], 'number'],
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
        $query = Cte::find();

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
            'forpag' => $this->forpag,
            'tpemis' => $this->tpemis,
            'tpcte' => $this->tpcte,
            'tpserv' => $this->tpserv,
            'retira' => $this->retira,
            'dhcont' => $this->dhcont,
            'toma' => $this->toma,
            'vtprest' => $this->vtprest,
            'vrec' => $this->vrec,
            'predbc' => $this->predbc,
            'vbc' => $this->vbc,
            'picms' => $this->picms,
            'vicms' => $this->vicms,
            'vbcstret' => $this->vbcstret,
            'vicmsret' => $this->vicmsret,
            'picmsret' => $this->picmsret,
            'vcred' => $this->vcred,
            'vtottrib' => $this->vtottrib,
            'outrauf' => $this->outrauf,
            'vcarga' => $this->vcarga,
            'respseg' => $this->respseg,
            'dprev' => $this->dprev,
            'lota' => $this->lota,
        ]);

        $query->andFilterWhere(['like', 'dono', $this->dono])
            ->andFilterWhere(['like', 'criusu', $this->criusu])
            ->andFilterWhere(['like', 'chave', $this->chave])
            ->andFilterWhere(['like', 'modelo', $this->modelo])
            ->andFilterWhere(['like', 'serie', $this->serie])
            ->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'cct', $this->cct])
            ->andFilterWhere(['like', 'cfop', $this->cfop])
            ->andFilterWhere(['like', 'natop', $this->natop])
            ->andFilterWhere(['like', 'refcte', $this->refcte])
            ->andFilterWhere(['like', 'cmunenv', $this->cmunenv])
            ->andFilterWhere(['like', 'xmunenv', $this->xmunenv])
            ->andFilterWhere(['like', 'ufenv', $this->ufenv])
            ->andFilterWhere(['like', 'modal', $this->modal])
            ->andFilterWhere(['like', 'cmunini', $this->cmunini])
            ->andFilterWhere(['like', 'xmunini', $this->xmunini])
            ->andFilterWhere(['like', 'ufini', $this->ufini])
            ->andFilterWhere(['like', 'cmunfim', $this->cmunfim])
            ->andFilterWhere(['like', 'xmunfim', $this->xmunfim])
            ->andFilterWhere(['like', 'uffim', $this->uffim])
            ->andFilterWhere(['like', 'xdetretira', $this->xdetretira])
            ->andFilterWhere(['like', 'xjust', $this->xjust])
            ->andFilterWhere(['like', 'tomador', $this->tomador])
            ->andFilterWhere(['like', 'remetente', $this->remetente])
            ->andFilterWhere(['like', 'destinatario', $this->destinatario])
            ->andFilterWhere(['like', 'recebedor', $this->recebedor])
            ->andFilterWhere(['like', 'expedidor', $this->expedidor])
            ->andFilterWhere(['like', 'cst', $this->cst])
            ->andFilterWhere(['like', 'prodpred', $this->prodpred])
            ->andFilterWhere(['like', 'xoutcat', $this->xoutcat])
            ->andFilterWhere(['like', 'xseg', $this->xseg])
            ->andFilterWhere(['like', 'napol', $this->napol])
            ->andFilterWhere(['like', 'rntrc', $this->rntrc])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}