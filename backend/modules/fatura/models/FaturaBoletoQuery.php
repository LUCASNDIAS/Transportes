<?php

namespace backend\modules\fatura\models;

/**
 * This is the ActiveQuery class for [[FaturaBoleto]].
 *
 * @see FaturaBoleto
 */
class FaturaBoletoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FaturaBoleto[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FaturaBoleto|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
