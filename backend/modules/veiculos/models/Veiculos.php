<?php

namespace backend\modules\veiculos\models;

use Yii;

/**
 * This is the model class for table "veiculos".
 *
 * @property int $id
 * @property string $marca
 * @property string $modelo
 * @property string $cint
 * @property string $renavam
 * @property string $placa
 * @property string $tara
 * @property string $capkg
 * @property string $capm3
 * @property string $tpprop
 * @property int $tpveic_id
 * @property int $tprod_id
 * @property int $tpcar_id
 * @property string $uf
 *
 * @property CteVeiculo[] $cteVeiculos
 * @property VeiculosTpcar $tpcar
 * @property VeiculosTprod $tprod
 * @property VeiculosTpveic $tpveic
 */
class Veiculos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'veiculos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['marca', 'modelo', 'placa', 'tara', 'capkg', 'capm3', 'tpprop', 'tpveic_id', 'tprod_id', 'tpcar_id', 'uf'], 'required'],
            [['tpveic_id', 'tprod_id', 'tpcar_id'], 'integer'],
            [['marca'], 'string', 'max' => 20],
            [['modelo'], 'string', 'max' => 60],
            [['cint', 'placa'], 'string', 'max' => 10],
            [['renavam'], 'string', 'max' => 11],
            [['tara', 'capkg', 'capm3'], 'string', 'max' => 6],
            [['tpprop'], 'string', 'max' => 1],
            [['uf'], 'string', 'max' => 2],
            [['tpcar_id'], 'exist', 'skipOnError' => true, 'targetClass' => VeiculosTpcar::className(), 'targetAttribute' => ['tpcar_id' => 'id']],
            [['tprod_id'], 'exist', 'skipOnError' => true, 'targetClass' => VeiculosTprod::className(), 'targetAttribute' => ['tprod_id' => 'id']],
            [['tpveic_id'], 'exist', 'skipOnError' => true, 'targetClass' => VeiculosTpveic::className(), 'targetAttribute' => ['tpveic_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'marca' => Yii::t('app', 'Marca'),
            'modelo' => Yii::t('app', 'Modelo'),
            'cint' => Yii::t('app', 'Código Interno'),
            'renavam' => Yii::t('app', 'RENAVAN'),
            'placa' => Yii::t('app', 'Placa'),
            'tara' => Yii::t('app', 'Tara'),
            'capkg' => Yii::t('app', 'Cap. Kg'),
            'capm3' => Yii::t('app', 'Cap. M3'),
            'tpprop' => Yii::t('app', 'Proprietário'),
            'tpveic_id' => Yii::t('app', 'Tipo de Veículo'),
            'tprod_id' => Yii::t('app', 'Tipo de rodado'),
            'tpcar_id' => Yii::t('app', 'Carroceria'),
            'uf' => Yii::t('app', 'UF'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCteVeiculos()
    {
        return $this->hasMany(CteVeiculo::className(), ['placa' => 'placa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTpcar()
    {
        return $this->hasOne(VeiculosTpcar::className(), ['id' => 'tpcar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTprod()
    {
        return $this->hasOne(VeiculosTprod::className(), ['id' => 'tprod_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTpveic()
    {
        return $this->hasOne(VeiculosTpveic::className(), ['id' => 'tpveic_id']);
    }

    public function getVeiculos() {

        $data = self::find()
                ->select('placa,modelo')
                ->where(['dono' => Yii::$app->user->identity['cnpj']])
                ->asArray()
                ->all();

        return $data;
    }

    /**
     * @inheritdoc
     * @return VeiculosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VeiculosQuery(get_called_class());
    }
}
