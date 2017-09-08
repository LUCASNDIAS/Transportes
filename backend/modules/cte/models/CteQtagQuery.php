<?php

namespace backend\modules\cte\models;

/**
 * This is the ActiveQuery class for [[CteQtag]].
 *
 * @see CteQtag
 */
class CteQtagQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CteQtag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CteQtag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
