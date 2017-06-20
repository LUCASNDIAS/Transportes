<?php

namespace backend\modules\mdfe\models;

use Yii;

/**
 * This is the model class for table "mdfe_condutor".
 *
 * @property int $id
 * @property int $mdfe_id
 * @property string $condutor
 *
 * @property Mdfe $mdfe
 */
class MdfeCondutor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mdfe_condutor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mdfe_id', 'condutor'], 'required'],
            [['mdfe_id'], 'integer'],
            [['condutor'], 'string', 'max' => 11],
            [['mdfe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mdfe::className(), 'targetAttribute' => ['mdfe_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'mdfe_id' => Yii::t('app', 'Mdfe ID'),
            'condutor' => Yii::t('app', 'Condutor'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdfe()
    {
        return $this->hasOne(Mdfe::className(), ['id' => 'mdfe_id']);
    }
}
