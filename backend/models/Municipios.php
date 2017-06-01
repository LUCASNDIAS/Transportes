<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "municipios_ibge".
 *
 * @property int $codigo
 * @property string $municipio
 * @property string $uf
 */
class Municipios extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'municipios_ibge';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['codigo'], 'required'],
            [['codigo'], 'integer'],
            [['municipio'], 'string', 'max' => 50],
            [['uf'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'codigo' => Yii::t('app', 'Codigo'),
            'municipio' => Yii::t('app', 'Municipio'),
            'uf' => Yii::t('app', 'Uf'),
        ];
    }

    public function listarNomes($clientes) {
        $pesquisa = self::find()
                ->select([
                    'codigo' => 'codigo',
                    'municipio' => 'municipio',
                    'uf' => 'uf'
                ]);
        foreach ($clientes as $cliente) {
            $pesquisa->orWhere([
                'uf' => $cliente['enduf'],
                'municipio' => $cliente['endcid']
            ]);
        }
        
        $municipios = $pesquisa->asArray()
                ->all();
        
        \Yii::$app->response->format = 'json';
        return $municipios;
    }

    /**
     * @inheritdoc
     * @return MunicipiosQuery the active query used by this AR class.
     */
    public static function find() {
        return new MunicipiosQuery(get_called_class());
    }

}
