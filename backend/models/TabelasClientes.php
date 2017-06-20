<?php

namespace backend\models;

use Yii;

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
            [['cliente_id', 'tabela_id'], 'required'],
            [['cliente_id', 'tabela_id'], 'integer'],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(),
                'targetAttribute' => ['cliente_id' => 'id']],
            [['tabela_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tabelas::className(),
                'targetAttribute' => ['tabela_id' => 'id']],
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

    public function getTabelasClientes($idcli)
    {
        $data = self::find()
                ->select('tabela_id')
                ->where(['cliente_id' => $idcli])
                ->asArray()
                ->all();

        return $data;
    }
}