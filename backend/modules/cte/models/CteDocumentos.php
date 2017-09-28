<?php

namespace backend\modules\cte\models;

use Yii;

/**
 * This is the model class for table "cte_documentos".
 *
 * @property int $id
 * @property int $cte_id
 * @property string $tipo
 * @property string $chave
 * @property string $nroma
 * @property string $nped
 * @property string $modelo
 * @property string $serie
 * @property string $ndoc
 * @property string $demi
 * @property double $vbc
 * @property double $vicms
 * @property double $vbcst
 * @property double $vst
 * @property double $vprod
 * @property double $vnf
 * @property string $ncfop
 * @property double $npeso
 * @property string $pin
 * @property string $dprev
 * @property double $altura
 * @property double $largura
 * @property double $comprimento
 * @property double $peso
 * @property double $cubado
 * @property double $volumes
 *
 * @property Cte $cte
 * @property Cte $cteDimensoes
 */
class CteDocumentos extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cte_documentos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cte_id', 'tipo', 'chave', 'vbc', 'vicms', 'vbcst', 'vst', 'vprod',
                'vnf', 'npeso', 'pin', 'altura', 'largura', 'comprimento', 'peso',
                'cubado'], 'required'],
            [['cte_id', 'volumes'], 'integer'],
            [['demi', 'dprev'], 'safe'],
            [['vbc', 'vicms', 'vbcst', 'vst', 'vprod', 'vnf', 'npeso', 'altura',
                'largura', 'comprimento', 'peso', 'cubado'], 'number'],
            [['tipo', 'nroma', 'nped', 'ndoc'], 'string', 'max' => 10],
            [['chave'], 'string', 'max' => 44],
            [['modelo', 'serie'], 'string', 'max' => 3],
            [['ncfop'], 'string', 'max' => 5],
            [['pin'], 'string', 'max' => 20],
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
            'tipo' => Yii::t('app', 'Tipo'),
            'chave' => Yii::t('app', 'Chave / Número'),
            'nroma' => Yii::t('app', 'Romaneio'),
            'nped' => Yii::t('app', 'Pedido'),
            'modelo' => Yii::t('app', 'Modelo'),
            'serie' => Yii::t('app', 'Série'),
            'ndoc' => Yii::t('app', 'Nº Doc.'),
            'demi' => Yii::t('app', 'Emissão'),
            'vbc' => Yii::t('app', 'R$ BC'),
            'vicms' => Yii::t('app', 'R$ ICMS'),
            'vbcst' => Yii::t('app', 'Vbcst'),
            'vst' => Yii::t('app', 'Vst'),
            'vprod' => Yii::t('app', 'R$ Produtos'),
            'vnf' => Yii::t('app', 'R$ Nota'),
            'ncfop' => Yii::t('app', 'CFOP'),
            'npeso' => Yii::t('app', 'Peso'),
            'pin' => Yii::t('app', 'Pin'),
            'dprev' => Yii::t('app', 'Previsão'),
            'altura' => Yii::t('app', 'Alt'),
            'largura' => Yii::t('app', 'Larg'),
            'comprimento' => Yii::t('app', 'Comp'),
            'peso' => Yii::t('app', 'Peso'),
            'cubado' => Yii::t('app', 'Cubado'),
            'volumes' => Yii::t('app', 'Vol'),
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
    public function getCteDimensoes()
    {
        return $this->hasMany(CteDimensoes::className(),
                ['documento_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CteDocumentosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CteDocumentosQuery(get_called_class());
    }
}