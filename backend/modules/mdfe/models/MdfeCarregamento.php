<?php

namespace backend\modules\mdfe\models;

use Yii;

/**
 * This is the model class for table "mdfe_carregamento".
 *
 * @property int $id
 * @property int $mdfe_id
 * @property string $cMun
 * @property string $xMun
 *
 * @property Mdfe $mdfe
 */
class MdfeCarregamento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mdfe_carregamento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mdfe_id', 'cMun', 'xMun'], 'required'],
            [['mdfe_id'], 'integer'],
            [['cMun'], 'string', 'max' => 7],
            [['xMun'], 'string', 'max' => 100],
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
            'cMun' => Yii::t('app', 'C Mun'),
            'xMun' => Yii::t('app', 'X Mun'),
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
