<?php

namespace backend\modules\clientes\models;

use Yii;
use app\components\ClienteValidator;

/**
 * This is the model class for table "clientes".
 *
 * @property int $id
 * @property string $cridt
 * @property string $criusu
 * @property string $dono
 * @property string $nome
 * @property string $cnpj
 * @property string $ie
 * @property string $endrua
 * @property string $endnro
 * @property string $endbairro
 * @property string $endcid
 * @property string $enduf
 * @property string $endcep
 * @property string $status
 *
 * @property ClientesContatos[] $clientesContatos
 * @property Cte[] $ctes
 * @property Cte[] $ctes0
 * @property Cte[] $ctes1
 * @property Cte[] $ctes2
 * @property Cte[] $ctes3
 * @property Cte[] $ctes4
 * @property TabelasClientes[] $tabelasClientes
 */
class Clientes extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cridt', 'criusu', 'dono', 'nome', 'cnpj', 'ie', 'endrua', 'endnro',
                'endbairro', 'endcid', 'enduf', 'endcep', 'status'], 'required'],
            [['cridt', 'criusu', 'dono', 'nome', 'ie', 'cnpj', 'endrua', 'endnro',
                'endbairro', 'endcid', 'enduf', 'endcep', 'status'], 'trim'],
            [['cridt'], 'safe'],
            [['criusu'], 'string', 'max' => 30],
            [['dono', 'ie'], 'string', 'max' => 20],
            [['nome', 'endrua'], 'string', 'max' => 100],
            [['cnpj'], 'string', 'max' => 14],
            [['endnro', 'endcep', 'status'], 'string', 'max' => 10],
            [['endbairro'], 'string', 'max' => 50],
            [['endcid'], 'string', 'max' => 80],
            [['enduf'], 'string', 'max' => 2],
            ['cnpj', 'match', 'pattern' => '/^([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})$/'],
            [['nome', 'endnro', 'endbairro', 'endrua', 'endcid'], 'match', 'pattern' => '/^([!-ÿ]{1}[ -ÿ]{0,}[!-ÿ]{1}|[!-ÿ]{1})$/'],
            ['ie', 'match', 'pattern' => '/^(ISENTO|[0-9]{0,14})$/'],
            ['cnpj', ClienteValidator::className(),
                'when' => function ($model) {
                    return $model->isNewRecord;
                }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cridt' => Yii::t('app', 'Data criação'),
            'criusu' => Yii::t('app', 'Usuário'),
            'dono' => Yii::t('app', 'Dono'),
            'nome' => Yii::t('app', 'Nome'),
            'cnpj' => Yii::t('app', 'CNPJ / CPF'),
            'ie' => Yii::t('app', 'Insc. Estadual'),
            'endrua' => Yii::t('app', 'Logradouro'),
            'endnro' => Yii::t('app', 'Número'),
            'endbairro' => Yii::t('app', 'Bairro'),
            'endcid' => Yii::t('app', 'Cidade'),
            'enduf' => Yii::t('app', 'UF'),
            'endcep' => Yii::t('app', 'CEP'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientesContatos()
    {
        return $this->hasMany(ClientesContatos::className(),
                ['clientes_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientesContato()
    {
        return $this->hasOne(ClientesContatos::className(),
                ['clientes_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCtes()
    {
        return $this->hasMany(Cte::className(), ['destinatario' => 'cnpj']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCtes0()
    {
        return $this->hasMany(Cte::className(), ['emitente' => 'cnpj']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCtes1()
    {
        return $this->hasMany(Cte::className(), ['expedidor' => 'cnpj']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCtes2()
    {
        return $this->hasMany(Cte::className(), ['recebedor' => 'cnpj']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCtes3()
    {
        return $this->hasMany(Cte::className(), ['remetente' => 'cnpj']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCtes4()
    {
        return $this->hasMany(Cte::className(), ['tomador' => 'cnpj']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabelasClientes()
    {
        return $this->hasMany(TabelasClientes::className(),
                ['cliente_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ClientesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientesQuery(get_called_class());
    }

    public function autoComplete()
    {

        $data = self::find()
            ->select([new \yii\db\Expression("`cnpj`, CONCAT( `nome`,' | ',`cnpj`) as label, id")])
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            ->asArray()
            ->all();

        return $data;
    }

    public function autoComplete2()
    {

        $data = self::find()
            ->select([new \yii\db\Expression("`cnpj` as value, CONCAT( `nome`,' | ',`cnpj`) as label, id")])
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            ->asArray()
            ->all();

        return $data;
    }

    public function getCidades($clientes)
    {

        $data = self::find()
            ->select('enduf,endcid')
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            ->andWhere(['in', 'cnpj', $clientes])
            ->asArray()
            ->all();

        return $data;
    }

    public function getIdClientes($cnpj)
    {

        $data = self::find()
            ->select('id')
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
//                ->where(['dono' => '11095658000140'])
            ->andWhere(['cnpj' => $cnpj])
            ->asArray()
            ->one();

        return $data;
    }

    public function retornaCliente($cnpj)
    {
        $query = self::find()
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            ->andWhere(['cnpj' => $cnpj])
            ->one();

        return $query;
    }

    public function Tabelas($cnpj)
    {

        $cliente    = $this->retornaCliente($cnpj);
        $id_cliente = $cliente->id;

        $tabelas = self::find()
            ->select('tabela_id')
            ->from('tabelas_clientes')
            ->where([
                'cliente_id' => $id_cliente
            ])
            ->asArray()
            ->all();

        // $array = explode('|', $tabelas['tabelas']);
        // $array = array_unique(preg_split('/\|/', $tabelas['tabelas'], -1, PREG_SPLIT_NO_EMPTY));

        return $tabelas;
    }

    public function getEmail($cnpj)
    {
        $cnpj1 = ($cnpj == '') ? '09835783624' : $cnpj;
        
        $cliente    = $this->retornaCliente($cnpj1);
        $id_cliente = $cliente->id;

        $email = self::find()
            ->select('email')
            ->from('clientes_contatos')
            ->where(['clientes_id' => $id_cliente])
            ->asArray()
            ->one();

//        $array = array_unique(preg_split('/\|/', $email['emails'], -1,
//                PREG_SPLIT_NO_EMPTY));

        return $email;
    }

    public function getNome($cnpj)
    {
        $nome = self::find()
            ->select('nome')
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            ->andWhere(['cnpj' => $cnpj])
            ->one();

        return $nome['nome'];
    }
}