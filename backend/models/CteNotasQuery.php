<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[CteNotas]].
 *
 * @see CteNotas
 */
class CteNotasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CteNotas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CteNotas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
