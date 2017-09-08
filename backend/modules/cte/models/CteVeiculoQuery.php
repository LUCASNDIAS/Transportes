<?php

namespace backend\modules\cte\models;

/**
 * This is the ActiveQuery class for [[CteVeiculo]].
 *
 * @see CteVeiculo
 */
class CteVeiculoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CteVeiculo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CteVeiculo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
