<?php

namespace backend\modules\veiculos\models;

/**
 * This is the ActiveQuery class for [[VeiculosTpveic]].
 *
 * @see VeiculosTpveic
 */
class VeiculosTpveicQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return VeiculosTpveic[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VeiculosTpveic|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
