<?php

namespace backend\modules\veiculos\models;

/**
 * This is the ActiveQuery class for [[VeiculosTprod]].
 *
 * @see VeiculosTprod
 */
class VeiculosTprodQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return VeiculosTprod[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VeiculosTprod|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
