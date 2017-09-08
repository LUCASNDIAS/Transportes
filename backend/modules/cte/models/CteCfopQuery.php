<?php

namespace backend\modules\cte\models;

/**
 * This is the ActiveQuery class for [[CteCfop]].
 *
 * @see CteCfop
 */
class CteCfopQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CteCfop[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CteCfop|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
