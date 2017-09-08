<?php

namespace backend\modules\cte\models;

/**
 * This is the ActiveQuery class for [[CteComponentes]].
 *
 * @see CteComponentes
 */
class CteComponentesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CteComponentes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CteComponentes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
