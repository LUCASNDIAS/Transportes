<?php

namespace backend\modules\cte\models;

/**
 * This is the ActiveQuery class for [[CteProtocolo]].
 *
 * @see CteProtocolo
 */
class CteProtocoloQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CteProtocolo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CteProtocolo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
