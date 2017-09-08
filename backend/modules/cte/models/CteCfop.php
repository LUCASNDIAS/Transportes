<?php

namespace backend\modules\cte\models;

use Yii;

/**
 * This is the model class for table "cte_cfop".
 *
 * @property int $id
 * @property string $cfop
 * @property string $nat
 * @property int $interestadual
 */
class CteCfop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cte_cfop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cfop', 'nat', 'interestadual'], 'required'],
            [['interestadual'], 'integer'],
            [['cfop'], 'string', 'max' => 5],
            [['nat'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cfop' => Yii::t('app', 'Cfop'),
            'nat' => Yii::t('app', 'Nat'),
            'interestadual' => Yii::t('app', 'Interestadual'),
        ];
    }

    /**
     * @inheritdoc
     * @return CteCfopQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CteCfopQuery(get_called_class());
    }
}
