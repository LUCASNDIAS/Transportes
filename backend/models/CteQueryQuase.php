<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Cte]].
 *
 * @see Cte
 */
class CteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Cte[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Cte|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
