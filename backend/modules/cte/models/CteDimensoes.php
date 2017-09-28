<?php

namespace backend\modules\cte\models;

use Yii;

/**
 * This is the model class for table "cte_dimensoes".
 *
 * @property int $id
 * @property int $documento_id
 * @property double $altura
 * @property double $largura
 * @property double $comprimento
 * @property int $volumes
 *
 * @property CteDocumentos $documento
 */
class CteDimensoes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cte_dimensoes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['documento_id', 'altura', 'largura', 'comprimento', 'volumes'], 'required'],
            [['documento_id', 'volumes'], 'integer'],
            [['altura', 'largura', 'comprimento'], 'number'],
            [['documento_id'], 'exist', 'skipOnError' => true, 'targetClass' => CteDocumentos::className(), 'targetAttribute' => ['documento_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'documento_id' => Yii::t('app', 'Documento ID'),
            'altura' => Yii::t('app', 'Altura'),
            'largura' => Yii::t('app', 'Largura'),
            'comprimento' => Yii::t('app', 'Comprimento'),
            'volumes' => Yii::t('app', 'Volumes'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumento()
    {
        return $this->hasOne(CteDocumentos::className(), ['id' => 'documento_id']);
    }

    /**
     * @inheritdoc
     * @return CteDimensoesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CteDimensoesQuery(get_called_class());
    }
}
