<?php

namespace backend\models;

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
 */
class Mensagens extends \yii\db\ActiveRecord {

    public $para;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'mensagens';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['data', 'para', 'titulo', 'mensagem', 'status'], 'required'],
            [['data'], 'safe'],
            [['para', 'status'], 'string', 'max' => 20],
            [['titulo'], 'string', 'max' => 100],
            [['mensagem'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'para' => 'Para',
            'titulo' => 'Titulo',
            'mensagem' => 'Mensagem',
            'status' => 'Status',
        ];
    }

    public function __construct() {
        $this->para = Yii::$app->user->identity['cnpj'];
    }

    /**
     * Verifica novas mensagens para o usuário
     * e retorna a quantidade apenas.
     * 
     * @return int quantidade de mensagens.
     */
    public function verificaNovas() {
        $novas = self::find()
                ->where(['status' => 0])
                ->andWhere(['>', 'databaixa', date('Y-m-d')])
                ->andWhere(['in', 'para', [$this->para, 'TODOS']])
                ->count();

        return $novas;
    }

    public function listarNovas() {
        $novas = self::find()
                ->where(['status' => 0])
                ->andWhere(['>', 'databaixa', date('Y-m-d')])
                ->andWhere(['in', 'para', [$this->para, 'TODOS']])
                ->limit(self::verificaNovas())
                ->all();

        //echo '<pre>';
        //print_r($novas);

        $retorno = array();

        foreach ($novas as $listar => $nova) {
            $retorno[] = [
                'id' => $nova['id'],
                'data' => $nova['data'],
                'para' => $nova['para'],
                'titulo' => $nova['titulo'],
                'mensagem' => $nova['mensagem'],
                'status' => $nova['status'],
                'dataleitura' => $nova['dataleitura'],
                'databaixa' => $nova['databaixa']
            ];
        }
        Yii::$app->response->format = 'json';
        return $retorno;
    }

}
