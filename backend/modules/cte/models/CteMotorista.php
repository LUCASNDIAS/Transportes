<?php

namespace backend\modules\cte\models;

use Yii;

/**
 * This is the model class for table "cte_motorista".
 *
 * @property int $id
 * @property int $cte_id
 * @property int $motorista_id
 *
 * @property Cte $cte
 * @property Funcionarios $motorista
 */
class CteMotorista extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cte_motorista';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cte_id', 'motorista_id'], 'required'],
            [['cte_id', 'motorista_id'], 'integer'],
            [['cte_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cte::className(), 'targetAttribute' => ['cte_id' => 'id']],
            [['motorista_id'], 'exist', 'skipOnError' => true, 'targetClass' => Funcionarios::className(), 'targetAttribute' => ['motorista_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cte_id' => Yii::t('app', 'Cte ID'),
            'motorista_id' => Yii::t('app', 'Motorista ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCte()
    {
        return $this->hasOne(Cte::className(), ['id' => 'cte_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMotorista()
    {
        return $this->hasOne(Funcionarios::className(), ['id' => 'motorista_id']);
    }

    /**
     * @inheritdoc
     * @return CteMotoristaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CteMotoristaQuery(get_called_class());
    }
}
