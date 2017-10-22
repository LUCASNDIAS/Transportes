<?php

namespace backend\modules\ordemcoleta\models;

/**
 * This is the ActiveQuery class for [[OrdemColeta]].
 *
 * @see OrdemColeta
 */
class OrdemColetaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrdemColeta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrdemColeta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
