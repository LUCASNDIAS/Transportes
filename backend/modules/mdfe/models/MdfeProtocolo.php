<?php

namespace backend\modules\mdfe\models;

use Yii;

/**
 * This is the model class for table "mdfe_protocolo".
 *
 * @property integer $id
 * @property integer $mdfe_id
 * @property string $dhrec
 * @property string $nprot
 * @property string $digval
 * @property string $cstat
 * @property string $xmotivo
 *
 * @property Mdfe $mdfe
 */
class MdfeProtocolo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mdfe_protocolo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mdfe_id', 'dhrec', 'nprot', 'digval', 'cstat', 'xmotivo'], 'required'],
            [['mdfe_id'], 'integer'],
            [['dhrec'], 'safe'],
            [['nprot'], 'string', 'max' => 20],
            [['digval', 'xmotivo'], 'string', 'max' => 100],
            [['cstat'], 'string', 'max' => 5],
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
    public function getMdfe()
    {
        return $this->hasOne(Mdfe::className(), ['id' => 'mdfe_id']);
    }

    /**
     * @inheritdoc
     * @return MdfeProtocoloQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MdfeProtocoloQuery(get_called_class());
    }
}
