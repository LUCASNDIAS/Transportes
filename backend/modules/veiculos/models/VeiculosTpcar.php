<?php

namespace backend\modules\veiculos\models;

use Yii;

/**
 * This is the model class for table "veiculos_tpcar".
 *
 * @property int $id
 * @property string $codigo
 * @property string $descricao
 *
 * @property Veiculos[] $veiculos
 */
class VeiculosTpcar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'veiculos_tpcar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'descricao'], 'required'],
            [['codigo'], 'string', 'max' => 5],
            [['descricao'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codigo' => Yii::t('app', 'Codigo'),
            'descricao' => Yii::t('app', 'Descricao'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVeiculos()
    {
        return $this->hasMany(Veiculos::className(), ['tpcar_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return VeiculosTpcarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VeiculosTpcarQuery(get_called_class());
    }
}
