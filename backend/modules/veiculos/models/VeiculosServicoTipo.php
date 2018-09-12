<?php

namespace backend\modules\veiculos\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "veiculos_servico_tipo".
 *
 * @property integer $id
 * @property string $nome
 * @property string $descricao
 * @property string $tipo
 *
 * @property VeiculosServico[] $veiculosServicos
 */
class VeiculosServicoTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'veiculos_servico_tipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'descricao', 'tipo'], 'required'],
            [['nome', 'descricao'], 'string', 'max' => 50],
            [['tipo'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nome' => Yii::t('app', 'Nome'),
            'descricao' => Yii::t('app', 'Descricao'),
            'tipo' => Yii::t('app', 'Tipo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVeiculosServicos()
    {
        return $this->hasMany(VeiculosServico::className(), ['tipo_servico' => 'id']);
    }

    /**
     * @inheritdoc
     * @return VeiculosServicoTipoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VeiculosServicoTipoQuery(get_called_class());
    }

    public function findTipo($tipo)
    {
        $model = VeiculosServicoTipo::findAll(['tipo' => $tipo]);
        $data = ArrayHelper::toArray($model, [
            'backend\modules\veiculos\models\VeiculosServicoTipo' => [
                'id',
                'nome',
                'descricao',
                'tipo'
            ],
        ]);

        return ArrayHelper::map($data,'id','nome');
    }
}