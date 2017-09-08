<?php

namespace backend\modules\cte\models;

use Yii;

/**
 * This is the model class for table "cte_componentes".
 *
 * @property int $id
 * @property int $cte_id
 * @property string $nome
 * @property double $valor
 *
 * @property Cte $cte
 */
class CteComponentes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cte_componentes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cte_id', 'nome', 'valor'], 'required'],
            [['cte_id'], 'integer'],
            [['valor'], 'number'],
            [['nome'], 'string', 'max' => 60],
            [['cte_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cte::className(), 'targetAttribute' => ['cte_id' => 'id']],
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
            'nome' => Yii::t('app', 'Nome'),
            'valor' => Yii::t('app', 'Valor'),
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
     * @inheritdoc
     * @return CteComponentesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CteComponentesQuery(get_called_class());
    }
}
