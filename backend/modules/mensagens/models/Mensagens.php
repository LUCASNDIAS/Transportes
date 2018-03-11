<?php

namespace backend\modules\mensagens\models;

use Yii;

/**
 * This is the model class for table "mensagens".
 *
 * @property integer $id
 * @property string $data
 * @property string $para
 * @property string $titulo
 * @property string $mensagem
 * @property string $status
 * @property string $dataleitura
 * @property string $databaixa
 */
class Mensagens extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mensagens';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data', 'para', 'titulo', 'mensagem', 'databaixa'], 'required'],
            [['data', 'dataleitura', 'databaixa'], 'safe'],
            [['para', 'status'], 'string', 'max' => 20],
            [['titulo'], 'string', 'max' => 100],
            [['mensagem'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'data' => Yii::t('app', 'Data'),
            'para' => Yii::t('app', 'Para'),
            'titulo' => Yii::t('app', 'Titulo'),
            'mensagem' => Yii::t('app', 'Mensagem'),
            'status' => Yii::t('app', 'Status'),
            'dataleitura' => Yii::t('app', 'Dataleitura'),
            'databaixa' => Yii::t('app', 'Databaixa'),
        ];
    }

    /**
     * @inheritdoc
     * @return MensagensQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MensagensQuery(get_called_class());
    }
}
