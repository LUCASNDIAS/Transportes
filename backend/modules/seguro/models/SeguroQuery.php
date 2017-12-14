<?php

namespace backend\modules\seguro\models;

/**
 * This is the ActiveQuery class for [[Seguro]].
 *
 * @see Seguro
 */
class SeguroQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Seguro[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Seguro|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
