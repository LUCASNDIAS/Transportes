<?php

namespace backend\modules\cte\models;

/**
 * This is the ActiveQuery class for [[CteDocant]].
 *
 * @see CteDocant
 */
class CteDocantQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CteDocant[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CteDocant|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
