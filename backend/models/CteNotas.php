<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cte_notas".
 *
 * @property int $id
 * @property int $cte_id
 * @property string $dono
 * @property string $notasnumero
 * @property string $notasvalor
 * @property string $notasaltura
 * @property string $notaslargura
 * @property string $notascomprimento
 * @property string $notaspeso
 * @property string $notasvolumes
 * @property string $notasdprev
 * @property string $notasnroma
 * @property string $notasnped
 * @property string $notasmod
 * @property string $notasserie
 * @property string $notasdemi
 * @property string $notasncfop
 * @property string $notaspin
 * @property string $notastpdoc
 * @property string $notasdescoutros
 * @property string $notasoutrosdemi
 *
 * @property Cte $id0
 */
class CteNotas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cte_notas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cte_id', 'dono', 'notasnumero', 'notasvalor', 'notasaltura', 'notaslargura', 'notascomprimento', 'notaspeso', 'notasvolumes', 'notasdprev', 'notasnroma', 'notasnped', 'notasmod', 'notasserie', 'notasdemi', 'notasncfop', 'notaspin', 'notastpdoc', 'notasdescoutros', 'notasoutrosdemi'], 'required'],
            [['cte_id'], 'integer'],
            [['notasdprev', 'notasdemi', 'notasoutrosdemi'], 'safe'],
            [['dono'], 'string', 'max' => 14],
            [['notasnumero'], 'string', 'max' => 44],
            [['notasvalor'], 'string', 'max' => 15],
            [['notasaltura', 'notaslargura', 'notascomprimento', 'notaspeso', 'notasvolumes', 'notasserie', 'notasncfop'], 'string', 'max' => 10],
            [['notasnroma', 'notasnped', 'notaspin'], 'string', 'max' => 20],
            [['notasmod', 'notastpdoc'], 'string', 'max' => 5],
            [['notasdescoutros'], 'string', 'max' => 25],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Cte::className(), 'targetAttribute' => ['id' => 'id']],
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
            'dono' => Yii::t('app', 'Dono'),
            'notasnumero' => Yii::t('app', 'Notasnumero'),
            'notasvalor' => Yii::t('app', 'Notasvalor'),
            'notasaltura' => Yii::t('app', 'Notasaltura'),
            'notaslargura' => Yii::t('app', 'Notaslargura'),
            'notascomprimento' => Yii::t('app', 'Notascomprimento'),
            'notaspeso' => Yii::t('app', 'Notaspeso'),
            'notasvolumes' => Yii::t('app', 'Notasvolumes'),
            'notasdprev' => Yii::t('app', 'Notasdprev'),
            'notasnroma' => Yii::t('app', 'Notasnroma'),
            'notasnped' => Yii::t('app', 'Notasnped'),
            'notasmod' => Yii::t('app', 'Notasmod'),
            'notasserie' => Yii::t('app', 'Notasserie'),
            'notasdemi' => Yii::t('app', 'Notasdemi'),
            'notasncfop' => Yii::t('app', 'Notasncfop'),
            'notaspin' => Yii::t('app', 'Notaspin'),
            'notastpdoc' => Yii::t('app', 'Notastpdoc'),
            'notasdescoutros' => Yii::t('app', 'Notasdescoutros'),
            'notasoutrosdemi' => Yii::t('app', 'Notasoutrosdemi'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Cte::className(), ['id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CteNotasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CteNotasQuery(get_called_class());
    }
}
