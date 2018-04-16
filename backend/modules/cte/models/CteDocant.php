<?php

namespace backend\modules\cte\models;

use Yii;
use backend\modules\clientes\models\Clientes;

/**
 * This is the model class for table "cte_docant".
 *
 * @property integer $id
 * @property integer $cte_id
 * @property string $cnpj
 * @property string $chave
 *
 * @property Cte $cte
 * @property Clientes $cnpj0
 */
class CteDocant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cte_docant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cte_id'], 'required'],
            [['cte_id'], 'integer'],
            [['cnpj'], 'string', 'max' => 14],
            [['chave'], 'string', 'max' => 44],
            [['cte_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cte::className(), 'targetAttribute' => ['cte_id' => 'id']],
            [['cnpj'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['cnpj' => 'cnpj']],
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
            'cnpj' => Yii::t('app', 'Emissor Anterior'),
            'chave' => Yii::t('app', 'Chave de acesso do CTE'),
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
    public function getCnpj0()
    {
        return $this->hasOne(Clientes::className(), ['cnpj' => 'cnpj']);
    }

    /**
     * @inheritdoc
     * @return CteDocantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CteDocantQuery(get_called_class());
    }
}
