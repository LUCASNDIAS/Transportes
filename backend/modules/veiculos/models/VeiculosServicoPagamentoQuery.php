<?php

namespace backend\modules\veiculos\models;

/**
 * This is the ActiveQuery class for [[VeiculosServicoPagamento]].
 *
 * @see VeiculosServicoPagamento
 */
class VeiculosServicoPagamentoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return VeiculosServicoPagamento[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VeiculosServicoPagamento|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
