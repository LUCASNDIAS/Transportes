<?php

namespace backend\modules\clientes\models;

/**
 * This is the ActiveQuery class for [[TabelasClientes]].
 *
 * @see TabelasClientes
 */
class TabelasClientesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TabelasClientes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabelasClientes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
