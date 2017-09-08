<?php

namespace backend\modules\cte\models;

use Yii;

/**
 * This is the model class for table "cte_qtag".
 *
 * @property int $id
 * @property int $cte_id
 * @property string $cunid
 * @property string $tpmed
 * @property double $qcarga
 *
 * @property Cte $cte
 */
class CteQtag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cte_qtag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cte_id', 'cunid', 'tpmed', 'qcarga'], 'required'],
            [['cte_id'], 'integer'],
            [['qcarga'], 'number'],
            [['cunid'], 'string', 'max' => 10],
            [['tpmed'], 'string', 'max' => 20],
            [['cte_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cte::className(), 'targetAttribute' => ['cte_id' => 'id']],
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
            'cunid' => Yii::t('app', 'Cunid'),
            'tpmed' => Yii::t('app', 'Tpmed'),
            'qcarga' => Yii::t('app', 'Qcarga'),
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
     * @inheritdoc
     * @return CteQtagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CteQtagQuery(get_called_class());
    }
}
