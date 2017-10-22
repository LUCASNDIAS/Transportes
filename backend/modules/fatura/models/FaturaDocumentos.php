<?php

namespace backend\modules\fatura\models;

use Yii;
use backend\models\Minutas;
use backend\modules\cte\models\Cte;

/**
 * This is the model class for table "fatura_documentos".
 *
 * @property integer $id
 * @property integer $fatura_id
 * @property integer $cte_id
 * @property integer $minuta_id
 *
 * @property Cte $cte
 * @property Fatura $fatura
 * @property Minutas $minuta
 */
class FaturaDocumentos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fatura_documentos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fatura_id'], 'required'],
            [['fatura_id', 'cte_id', 'minuta_id'], 'default'],
            [['cte_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cte::className(), 'targetAttribute' => ['cte_id' => 'id']],
            [['fatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fatura::className(), 'targetAttribute' => ['fatura_id' => 'id']],
            [['minuta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Minutas::className(), 'targetAttribute' => ['minuta_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fatura_id' => Yii::t('app', 'Fatura ID'),
            'cte_id' => Yii::t('app', 'Cte ID'),
            'minuta_id' => Yii::t('app', 'Minuta ID'),
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
    public function getFatura()
    {
        return $this->hasOne(Fatura::className(), ['id' => 'fatura_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMinuta()
    {
        return $this->hasOne(Minutas::className(), ['id' => 'minuta_id']);
    }

    /**
     * @inheritdoc
     * @return FaturaDocumentosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FaturaDocumentosQuery(get_called_class());
    }
}
