<?php

namespace backend\modules\mdfe\models;

use Yii;

/**
 * This is the model class for table "mdfe_documentos".
 *
 * @property int $id
 * @property int $mdfe_id
 * @property string $chave
 * @property string $emitente
 * @property string $numero
 * @property string $dtemissao
 * @property string $uf
 * @property string $pin
 * @property string $serie
 * @property double $valor
 *
 * @property Mdfe $mdfe
 */
class MdfeDocumentos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mdfe_documentos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mdfe_id', 'chave', 'emitente', 'numero', 'dtemissao', 'uf', 'pin', 'serie', 'valor'], 'required'],
            [['mdfe_id'], 'integer'],
            [['dtemissao'], 'safe'],
            [['valor'], 'number'],
            [['chave'], 'string', 'max' => 44],
            [['emitente'], 'string', 'max' => 14],
            [['numero'], 'string', 'max' => 9],
            [['uf'], 'string', 'max' => 2],
            [['pin'], 'string', 'max' => 20],
            [['serie'], 'string', 'max' => 3],
            [['mdfe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mdfe::className(), 'targetAttribute' => ['mdfe_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'mdfe_id' => Yii::t('app', 'Mdfe ID'),
            'chave' => Yii::t('app', 'Chave'),
            'emitente' => Yii::t('app', 'Emitente'),
            'numero' => Yii::t('app', 'Numero'),
            'dtemissao' => Yii::t('app', 'Dtemissao'),
            'uf' => Yii::t('app', 'Uf'),
            'pin' => Yii::t('app', 'Pin'),
            'serie' => Yii::t('app', 'Serie'),
            'valor' => Yii::t('app', 'Valor'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdfe()
    {
        return $this->hasOne(Mdfe::className(), ['id' => 'mdfe_id']);
    }
}
