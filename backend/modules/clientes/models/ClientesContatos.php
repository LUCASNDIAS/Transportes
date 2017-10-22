<?php

namespace backend\modules\clientes\models;

use Yii;

/**
 * This is the model class for table "clientes_contatos".
 *
 * @property int $id
 * @property int $clientes_id
 * @property string $nome
 * @property string $email
 * @property string $telefone
 *
 * @property Clientes $clientes
 */
class ClientesContatos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clientes_contatos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clientes_id', 'telefone'], 'required'],
            [['clientes_id'], 'integer'],
            [['nome'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 100],
            [['telefone'], 'string', 'max' => 15],
            [['clientes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['clientes_id' => 'id']],
            [['email'],'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'clientes_id' => Yii::t('app', 'Cliente'),
            'nome' => Yii::t('app', 'Responsável'),
            'email' => Yii::t('app', 'E-mail'),
            'telefone' => Yii::t('app', 'Telefone'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasOne(Clientes::className(), ['id' => 'clientes_id']);
    }

    /**
     * @inheritdoc
     * @return ClientesContatosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientesContatosQuery(get_called_class());
    }
}
