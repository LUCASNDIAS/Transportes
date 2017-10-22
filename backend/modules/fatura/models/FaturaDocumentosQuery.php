<?php

namespace backend\modules\fatura\models;

/**
 * This is the ActiveQuery class for [[FaturaDocumentos]].
 *
 * @see FaturaDocumentos
 */
class FaturaDocumentosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FaturaDocumentos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FaturaDocumentos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
