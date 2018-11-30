<?php

namespace backend\modules\clientes\models;

use Yii;

/**
 * This is the model class for table "clientes_prefs".
 *
 * @property integer $id
 * @property integer $cliente
 * @property string $tema
 * @property integer $financeiro
 * @property integer $veiculos
 *
 * @property Clientes $cliente0
 */
class ClientesPrefs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clientes_prefs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cliente', 'tema', 'financeiro', 'veiculos'], 'required'],
            [['cliente', 'financeiro', 'veiculos'], 'integer'],
            [['tema'], 'string', 'max' => 20],
            [['cliente'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['cliente' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cliente' => Yii::t('app', 'Cliente'),
            'tema' => Yii::t('app', 'Tema'),
            'financeiro' => Yii::t('app', 'Financeiro'),
            'veiculos' => Yii::t('app', 'Veiculos'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente0()
    {
        return $this->hasOne(Clientes::className(), ['id' => 'cliente']);
    }

    /**
     * @inheritdoc
     * @return ClientesPrefsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientesPrefsQuery(get_called_class());
    }
}
