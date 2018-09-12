<?php

namespace backend\modules\veiculos\models;

/**
 * This is the ActiveQuery class for [[VeiculosServicoTipo]].
 *
 * @see VeiculosServicoTipo
 */
class VeiculosServicoTipoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return VeiculosServicoTipo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VeiculosServicoTipo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
