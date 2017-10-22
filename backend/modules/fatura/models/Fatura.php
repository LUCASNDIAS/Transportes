<?php

namespace backend\modules\fatura\models;

use Yii;
use backend\modules\clientes\models\Clientes;

/**
 * This is the model class for table "fatura".
 *
 * @property integer $id
 * @property string $criusu
 * @property string $cridt
 * @property string $dono
 * @property integer $numero
 * @property string $tipo
 * @property string $emissao
 * @property string $vencimento
 * @property string $observacoes
 * @property string $sacado
 * @property string $pagamento
 * @property string $status
 *
 * @property Clientes $sacado0
 * @property FaturaDocumentos[] $faturaDocumentos
 * @property Financeiro[] $financeiros
 */
class Fatura extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fatura';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipo', 'emissao', 'vencimento', 'sacado'], 'required'],
            [['cridt', 'emissao', 'vencimento', 'pagamento'], 'default'],
            [['numero'], 'integer'],
            [['criusu', 'status'], 'string', 'max' => 20],
            [['dono', 'sacado'], 'string', 'max' => 14],
            [['tipo'], 'string', 'max' => 6],
            [['observacoes'], 'string', 'max' => 300],
            [['sacado'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['sacado' => 'cnpj']],
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
            'numero' => Yii::t('app', 'Número'),
            'tipo' => Yii::t('app', 'Tipo'),
            'emissao' => Yii::t('app', 'Emissão'),
            'vencimento' => Yii::t('app', 'Vencimento'),
            'observacoes' => Yii::t('app', 'Observações'),
            'sacado' => Yii::t('app', 'Sacado'),
            'pagamento' => Yii::t('app', 'Pagamento'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSacado0()
    {
        return $this->hasOne(Clientes::className(), ['cnpj' => 'sacado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaturaDocumentos()
    {
        return $this->hasMany(FaturaDocumentos::className(), ['fatura_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceiros()
    {
        return $this->hasMany(Financeiro::className(), ['fatura' => 'id']);
    }

    public function getLastId()
    {
        $last = self::find()
            ->select(['numero'])
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            ->andWhere(['NOT LIKE', 'status', 'DELETADO'])
            ->orderBy('numero DESC')
            ->asArray()
            ->one();

        return (is_null($last)) ? 1 : $last['numero'] + 1;
    }

    /**
     * @inheritdoc
     * @return FaturaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FaturaQuery(get_called_class());
    }
}
