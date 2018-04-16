<?php

namespace backend\modules\mdfe\models;

/**
 * This is the ActiveQuery class for [[MdfeProtocolo]].
 *
 * @see MdfeProtocolo
 */
class MdfeProtocoloQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MdfeProtocolo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MdfeProtocolo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
