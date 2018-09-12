<?php

namespace backend\modules\veiculos\models;

use backend\commands\Basicos;
use backend\modules\financeiro\models\Financeiro;
use Yii;

/**
 * This is the model class for table "veiculos_abastecimento".
 *
 * @property integer $id
 * @property string $cridt
 * @property string $criusu
 * @property string $dono
 * @property integer $veiculo
 * @property double $odometro
 * @property string $data
 * @property string $combustivel
 * @property string $posto
 * @property integer $cheio
 * @property double $valor_total
 * @property double $litros
 * @property integer $financeiro
 *
 * @property Veiculos $veiculo0
 */
class VeiculosAbastecimento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'veiculos_abastecimento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['veiculo', 'odometro', 'data', 'combustivel', 'posto', 'cheio', 'valor_total', 'litros'], 'required'],
            [['veiculo', 'cheio'], 'integer'],
            [['odometro', 'valor_total', 'litros'], 'number'],
            [['data', 'cridt'], 'safe'],
            [['combustivel', 'dono'], 'string', 'max' => 20],
            [['posto'], 'string', 'max' => 50],
            [['criusu'], 'string', 'max' => 30],
            [['data'], 'match', 'pattern' => '/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})|([0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]))$/'],
            [['veiculo'], 'exist', 'skipOnError' => true, 'targetClass' => Veiculos::className(), 'targetAttribute' => ['veiculo' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cridt' => Yii::t('app', 'Data criação'),
            'criusu' => Yii::t('app', 'Usuário'),
            'dono' => Yii::t('app', 'Dono'),
            'veiculo' => Yii::t('app', 'Veículo'),
            'odometro' => Yii::t('app', 'Odometro'),
            'data' => Yii::t('app', 'Data'),
            'combustivel' => Yii::t('app', 'Combustível'),
            'posto' => Yii::t('app', 'Posto'),
            'cheio' => Yii::t('app', 'Tanque Cheio'),
            'valor_total' => Yii::t('app', 'Valor total R$'),
            'litros' => Yii::t('app', 'Litros'),
            'financeiro' => Yii::t('app', 'Financeiro'),
        ];
    }

    public function beforeSave($insert)
    {
        $basicos = new Basicos();

        if (parent::beforeSave($insert)) {

            $this->data = ($this->data == '') ? null : $basicos->formataData('db', ($this->data));

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVeiculo0()
    {
        return $this->hasOne(Veiculos::className(), ['id' => 'veiculo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceiro0()
    {
        return $this->hasOne(Financeiro::className(), ['id' => 'financeiro']);
    }

    /**
     * @inheritdoc
     * @return VeiculosAbastecimentoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VeiculosAbastecimentoQuery(get_called_class());
    }
}
