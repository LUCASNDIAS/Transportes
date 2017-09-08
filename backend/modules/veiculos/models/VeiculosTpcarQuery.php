<?php

namespace backend\modules\veiculos\models;

/**
 * This is the ActiveQuery class for [[VeiculosTpcar]].
 *
 * @see VeiculosTpcar
 */
class VeiculosTpcarQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return VeiculosTpcar[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VeiculosTpcar|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
