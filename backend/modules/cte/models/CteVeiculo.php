<?php

namespace backend\modules\cte\models;

use Yii;
use backend\modules\veiculos\models\Veiculos;

/**
 * This is the model class for table "cte_veiculo".
 *
 * @property int $id
 * @property int $cte_id
 * @property string $placa
 *
 * @property Cte $cte
 */
class CteVeiculo extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cte_veiculo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cte_id'], 'required'],
            [['cte_id'], 'integer'],
            [['placa'], 'string', 'max' => 10],
            [['cte_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cte::className(),
                'targetAttribute' => ['cte_id' => 'id']],
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
            'placa' => Yii::t('app', 'Placa'),
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
    public function getVeiculos()
    {
        return $this->hasOne(Veiculos::className(), ['placa' => 'placa']);
    }

    /**
     * @inheritdoc
     * @return CteVeiculoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CteVeiculoQuery(get_called_class());
    }
}