<?php

namespace backend\modules\fatura\models;

/**
 * This is the ActiveQuery class for [[Fatura]].
 *
 * @see Fatura
 */
class FaturaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Fatura[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Fatura|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
