<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Minutas]].
 *
 * @see Minutas
 */
class MinutasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Minutas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Minutas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
