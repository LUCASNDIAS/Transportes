<?php

namespace backend\modules\cte\models;

use Yii;

/**
 * This is the model class for table "cte_protocolo".
 *
 * @property int $id
 * @property int $cte_id
 * @property string $dhrec
 * @property string $nprot
 * @property string $digval
 * @property string $cstat
 * @property string $xmotivo
 *
 * @property Cte $cte
 */
class CteProtocolo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cte_protocolo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cte_id', 'dhrec', 'nprot', 'digval', 'cstat', 'xmotivo'], 'required'],
            [['cte_id'], 'integer'],
            [['dhrec'], 'safe'],
            [['nprot'], 'string', 'max' => 20],
            [['digval', 'xmotivo'], 'string', 'max' => 100],
            [['cstat'], 'string', 'max' => 5],
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
            'dhrec' => Yii::t('app', 'Dhrec'),
            'nprot' => Yii::t('app', 'Nprot'),
            'digval' => Yii::t('app', 'Digval'),
            'cstat' => Yii::t('app', 'Cstat'),
            'xmotivo' => Yii::t('app', 'Xmotivo'),
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
     * @return CteProtocoloQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CteProtocoloQuery(get_called_class());
    }
}
