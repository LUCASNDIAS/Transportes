<?php

namespace backend\modules\mensagens\models;

/**
 * This is the ActiveQuery class for [[Mensagens]].
 *
 * @see Mensagens
 */
class MensagensQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Mensagens[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Mensagens|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
