<?php

namespace backend\modules\veiculos\models;

/**
 * This is the ActiveQuery class for [[Veiculos]].
 *
 * @see Veiculos
 */
class VeiculosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Veiculos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Veiculos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
