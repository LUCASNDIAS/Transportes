<?php

namespace backend\modules\seguro\models;

use Yii;
use backend\modules\clientes\models\Clientes;

/**
 * This is the model class for table "seguro".
 *
 * @property integer $id
 * @property string $dono
 * @property string $cridt
 * @property string $criusu
 * @property string $xseg
 * @property string $cnpj
 * @property string $napol
 * @property string $naver
 *
 * @property Clientes $dono0
 */
class Seguro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seguro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dono', 'cridt', 'criusu', 'xseg', 'cnpj', 'napol'], 'required'],
            [['cridt'], 'safe'],
            [['dono', 'criusu', 'cnpj'], 'string', 'max' => 14],
            [['xseg'], 'string', 'max' => 30],
            [['napol'], 'string', 'max' => 20],
            [['naver'], 'string', 'max' => 40],
            [['dono'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['dono' => 'cnpj']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'dono' => Yii::t('app', 'Dono'),
            'cridt' => Yii::t('app', 'Data de criação'),
            'criusu' => Yii::t('app', 'Usuário'),
            'xseg' => Yii::t('app', 'Seguradora'),
            'cnpj' => Yii::t('app', 'CNPJ'),
            'napol' => Yii::t('app', 'Apólice'),
            'naver' => Yii::t('app', 'Averbação'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDono0()
    {
        return $this->hasOne(Clientes::className(), ['cnpj' => 'dono']);
    }

    /**
     * @inheritdoc
     * @return SeguroQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeguroQuery(get_called_class());
    }
}
