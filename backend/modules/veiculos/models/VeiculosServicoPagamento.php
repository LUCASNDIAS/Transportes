<?php

namespace backend\modules\veiculos\models;

use backend\commands\Basicos;
use backend\modules\financeiro\models\Financeiro;
use Yii;

/**
 * This is the model class for table "veiculos_servico_pagamento".
 *
 * @property integer $id
 * @property integer $servico
 * @property integer $financeiro
 * @property integer $parcela
 * @property string $vencimento
 * @property double $valor
 *
 * @property Financeiro $financeiro0
 * @property VeiculosServico $servico0
 */
class VeiculosServicoPagamento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'veiculos_servico_pagamento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['servico', 'financeiro', 'parcela', 'vencimento', 'valor'], 'required'],
            [['servico', 'financeiro', 'parcela'], 'integer'],
            [['vencimento'], 'safe'],
            [['valor'], 'number'],
            [['financeiro'], 'exist', 'skipOnError' => true, 'targetClass' => Financeiro::className(), 'targetAttribute' => ['financeiro' => 'id']],
            [['servico'], 'exist', 'skipOnError' => true, 'targetClass' => VeiculosServico::className(), 'targetAttribute' => ['servico' => 'id']],
        ];
    }

    public function beforeSave($insert) {
        $basicos = new Basicos();

        if (parent::beforeSave($insert)) {

            // Transforma as datas
            $this->vencimento = ($this->vencimento == '') ? null : $basicos->formataData('db', ($this->vencimento));

            return true;
        } else {

            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'servico' => Yii::t('app', 'Servico'),
            'financeiro' => Yii::t('app', 'Financeiro'),
            'parcela' => Yii::t('app', 'Parcela'),
            'vencimento' => Yii::t('app', 'Vencimento'),
            'valor' => Yii::t('app', 'Valor'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceiro0()
    {
        return $this->hasOne(Financeiro::className(), ['id' => 'financeiro']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServico0()
    {
        return $this->hasOne(VeiculosServico::className(), ['id' => 'servico']);
    }

    /**
     * @inheritdoc
     * @return VeiculosServicoPagamentoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VeiculosServicoPagamentoQuery(get_called_class());
    }
}
