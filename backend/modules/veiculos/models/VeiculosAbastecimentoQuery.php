<?php

namespace backend\modules\veiculos\models;

/**
 * This is the ActiveQuery class for [[VeiculosAbastecimento]].
 *
 * @see VeiculosAbastecimento
 */
class VeiculosAbastecimentoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return VeiculosAbastecimento[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VeiculosAbastecimento|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
