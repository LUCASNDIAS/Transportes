<?php

namespace backend\modules\cotacao\models;

/**
 * This is the ActiveQuery class for [[Cotacao]].
 *
 * @see Cotacao
 */
class CotacaoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Cotacao[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Cotacao|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
