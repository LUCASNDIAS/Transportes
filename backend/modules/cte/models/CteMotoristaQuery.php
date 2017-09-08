<?php

namespace backend\modules\cte\models;

/**
 * This is the ActiveQuery class for [[CteMotorista]].
 *
 * @see CteMotorista
 */
class CteMotoristaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CteMotorista[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CteMotorista|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
