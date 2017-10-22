<?php

namespace backend\modules\financeiro\models;

/**
 * This is the ActiveQuery class for [[Financeiro]].
 *
 * @see Financeiro
 */
class FinanceiroQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Financeiro[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Financeiro|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
