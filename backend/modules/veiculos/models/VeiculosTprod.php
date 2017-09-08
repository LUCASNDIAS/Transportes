<?php

namespace backend\modules\veiculos\models;

use Yii;

/**
 * This is the model class for table "veiculos_tprod".
 *
 * @property int $id
 * @property string $codigo
 * @property string $descricao
 *
 * @property Veiculos[] $veiculos
 */
class VeiculosTprod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'veiculos_tprod';
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
        return $this->hasMany(Veiculos::className(), ['tprod_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return VeiculosTprodQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VeiculosTprodQuery(get_called_class());
    }
}
