<?php

namespace backend\modules\cte\models;

/**
 * This is the ActiveQuery class for [[CteDocumentos]].
 *
 * @see CteDocumentos
 */
class CteDocumentosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CteDocumentos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CteDocumentos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
