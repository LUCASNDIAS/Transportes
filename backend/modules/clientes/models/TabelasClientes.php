<?php

namespace backend\modules\clientes\models;

use Yii;
use backend\models\Tabelas;

/**
 * This is the model class for table "tabelas_clientes".
 *
 * @property int $id
 * @property int $cliente_id
 * @property int $tabela_id
 *
 * @property Clientes $cliente
 * @property Tabelas $tabela
 */
class TabelasClientes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tabelas_clientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cliente_id'], 'required'],
            [['cliente_id', 'tabela_id'], 'integer'],
            [['tabela_id'], 'unique'],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['cliente_id' => 'id']],
            [['tabela_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tabelas::className(), 'targetAttribute' => ['tabela_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cliente_id' => Yii::t('app', 'Cliente ID'),
            'tabela_id' => Yii::t('app', 'Tabela ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Clientes::className(), ['id' => 'cliente_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabela()
    {
        return $this->hasOne(Tabelas::className(), ['id' => 'tabela_id']);
    }

    /**
     * @inheritdoc
     * @return TabelasClientesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TabelasClientesQuery(get_called_class());
    }
}
