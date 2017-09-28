<?php

namespace backend\modules\cte\models;

/**
 * This is the ActiveQuery class for [[CteDimensoes]].
 *
 * @see CteDimensoes
 */
class CteDimensoesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CteDimensoes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CteDimensoes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
