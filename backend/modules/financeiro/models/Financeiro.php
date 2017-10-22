<?php

namespace backend\modules\financeiro\models;

use Yii;
use backend\modules\clientes\models\Clientes;
use backend\modules\fatura\models\Fatura;
use backend\modules\fatura\models\FaturaDocumentos;

/**
 * This is the model class for table "financeiro".
 *
 * @property integer $id
 * @property string $criusu
 * @property string $cridt
 * @property string $dono
 * @property string $nome
 * @property string $descricao
 * @property string $emissao
 * @property string $vencimento
 * @property double $valor
 * @property string $observacoes
 * @property string $cpgto
 * @property string $dtpgto
 * @property string $sacado
 * @property integer $fatura
 * @property integer $tipo
 * @property string $status
 *
 * @property Fatura $fatura0
 * @property Clientes $sacado0
 */
class Financeiro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'financeiro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['criusu', 'cridt', 'dono', 'nome', 'emissao', 'vencimento', 'valor'], 'required'],
            [['cridt', 'emissao', 'vencimento', 'dtpgto', 'fatura', 'sacado'], 'default'],
            [['valor'], 'number'],
            [['fatura'], 'integer'],
            [['criusu'], 'string', 'max' => 20],
            [['dono', 'sacado'], 'string', 'max' => 14],
            [['nome'], 'string', 'max' => 100],
            [['tipo'], 'string', 'max' => 1],
            [['descricao'], 'string', 'max' => 200],
            [['observacoes'], 'string', 'max' => 300],
            [['cpgto'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 30],
            [['fatura'], 'exist', 'skipOnError' => true, 'targetClass' => Fatura::className(), 'targetAttribute' => ['fatura' => 'id']],
            [['sacado'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['sacado' => 'cnpj']],
            [['emissao', 'vencimento', 'dtpgto'], 'match', 'pattern' => '/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})|([0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]))$/'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'criusu' => Yii::t('app', 'Usuário'),
            'cridt' => Yii::t('app', 'Data de criação'),
            'dono' => Yii::t('app', 'Dono'),
            'nome' => Yii::t('app', 'Nome'),
            'descricao' => Yii::t('app', 'Descrição'),
            'emissao' => Yii::t('app', 'Emissão'),
            'vencimento' => Yii::t('app', 'Vencimento'),
            'valor' => Yii::t('app', 'Valor'),
            'observacoes' => Yii::t('app', 'Observações'),
            'cpgto' => Yii::t('app', 'Comprov. Pgto'),
            'dtpgto' => Yii::t('app', 'Data Pgto'),
            'sacado' => Yii::t('app', 'Sacado'),
            'fatura' => Yii::t('app', 'Fatura'),
            'tipo' => Yii::t('app', 'Tipo'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFatura0()
    {
        return $this->hasOne(Fatura::className(), ['id' => 'fatura']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSacado0()
    {
        return $this->hasOne(Clientes::className(), ['cnpj' => 'sacado']);
    }

    /**
     * @inheritdoc
     * @return FinanceiroQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FinanceiroQuery(get_called_class());
    }
}
