<?php

namespace backend\modules\mdfe\models;

/**
 * This is the ActiveQuery class for [[Mdfe]].
 *
 * @see Mdfe
 */
class MdfeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Mdfe[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Mdfe|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
