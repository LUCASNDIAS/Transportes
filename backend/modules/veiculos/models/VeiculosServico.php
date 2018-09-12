<?php

namespace backend\modules\veiculos\models;

use backend\commands\Basicos;
use backend\modules\financeiro\models\Financeiro;
use Yii;

/**
 * This is the model class for table "veiculos_servico".
 *
 * @property integer $id
 * @property string $cridt
 * @property string $criusu
 * @property string $dono
 * @property string $tipo
 * @property integer $veiculo
 * @property double $odometro
 * @property string $data
 * @property integer $tipo_servico
 * @property double $valor_total
 * @property integer $parcelas
 * @property double $prox_odometro
 * @property string $prox_data
 * @property string $local
 * @property string $detalhes
 * @property string $observacoes
 *
 * @property Veiculos $veiculo0
 * @property VeiculosServicoTipo $tipoServico
 * @property VeiculosServicoPagamento $pagamentoServico
 */
class VeiculosServico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'veiculos_servico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cridt', 'criusu', 'dono', 'veiculo', 'odometro', 'data', 'tipo_servico', 'valor_total', 'parcelas', 'local', 'detalhes', 'observacoes'], 'required'],
            [['cridt', 'data', 'prox_data'], 'safe'],
            [['veiculo', 'tipo_servico', 'parcelas'], 'integer'],
            [['odometro', 'valor_total', 'prox_odometro'], 'number'],
            [['criusu'], 'string', 'max' => 30],
            [['dono'], 'string', 'max' => 20],
            [['local'], 'string', 'max' => 50],
            [['tipo'], 'string', 'max' => 1],
            [['detalhes', 'observacoes'], 'string', 'max' => 100],
            [['veiculo'], 'exist', 'skipOnError' => true, 'targetClass' => Veiculos::className(), 'targetAttribute' => ['veiculo' => 'id']],
            [['tipo_servico'], 'exist', 'skipOnError' => true, 'targetClass' => VeiculosServicoTipo::className(), 'targetAttribute' => ['tipo_servico' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cridt' => Yii::t('app', 'Data de criação'),
            'criusu' => Yii::t('app', 'Usuário'),
            'dono' => Yii::t('app', 'Dono'),
            'tipo' => Yii::t('app', 'Tipo'),
            'veiculo' => Yii::t('app', 'Veículo'),
            'odometro' => Yii::t('app', 'Odometro'),
            'data' => Yii::t('app', 'Data'),
            'tipo_servico' => Yii::t('app', 'Tipo'),
            'valor_total' => Yii::t('app', 'Valor Total'),
            'parcelas' => Yii::t('app', 'Parcelas'),
            'prox_odometro' => Yii::t('app', 'KM prox.'),
            'prox_data' => Yii::t('app', 'Data prox'),
            'local' => Yii::t('app', 'Local'),
            'detalhes' => Yii::t('app', 'Detalhes'),
            'observacoes' => Yii::t('app', 'Observações'),
        ];
    }

    public function beforeSave($insert) {
        $basicos = new Basicos();

        if (parent::beforeSave($insert)) {

            // Transforma as datas
            $this->data = ($this->data == '') ? null : $basicos->formataData('db', ($this->data));
            $this->prox_data = ($this->prox_data == '') ? null : $basicos->formataData('db', ($this->prox_data));

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
    public function getTipoServico()
    {
        return $this->hasOne(VeiculosServicoTipo::className(), ['id' => 'tipo_servico']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPagamentoServico()
    {
        return $this->hasMany(VeiculosServicoPagamento::className(), ['servico' => 'id']);
    }

    /**
     * @inheritdoc
     * @return VeiculosServicoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VeiculosServicoQuery(get_called_class());
    }
}
