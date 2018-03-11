<?php

namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "usuarios".
 *
 * @property integer $id
 * @property string $nome
 * @property string $login
 * @property string $senha
 * @property string $cnpj
 * @property string $apelido
 * @property string $diretorio
 * @property string $pasta
 * @property string $adm
 * @property string $ubd
 * @property string $sbd
 * @property string $bd
 * @property string $authkey
 * @property string $accesstoken
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $montaQuery;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'nome',
                    'login',
                    'senha',
                    'cnpj',
                    'apelido',
                    'diretorio',
                    'pasta',
                    'adm',
                    'ubd',
                    'sbd',
                    'bd',
                    'authkey',
                    'accesstoken'
                ],
                'required'
            ],
            [
                [
                    'nome',
                    'apelido',
                    'diretorio',
                    'authkey',
                    'accesstoken'
                ],
                'string',
                'max' => 200
            ],
            [
                [
                    'login',
                    'senha'
                ],
                'string',
                'max' => 32
            ],
            [
                [
                    'cnpj'
                ],
                'string',
                'max' => 15
            ],
            [
                [
                    'pasta'
                ],
                'string',
                'max' => 100
            ],
            [
                [
                    'adm'
                ],
                'string',
                'max' => 10
            ],
            [
                [
                    'ubd',
                    'sbd',
                    'bd'
                ],
                'string',
                'max' => 50
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'login' => 'Login',
            'senha' => 'Senha',
            'cnpj' => 'Cnpj',
            'apelido' => 'Apelido',
            'foto' => 'Foto',
            'authkey' => 'Authkey',
            'accesstoken' => 'Accesstoken'
        ];
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // return static::findOne ( [ 'access_token' => $token ] );
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authkey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authkey === $authKey;
    }

    public static function findByUsername($username)
    {
        return self::findOne(['login' => md5($username)]);
    }

    public function testeQuery()
    {

        $this->montaQuery = (new Query());

        //$rQuery =
        $this->montaQuery
            ->select('nome,cnpj,senha')
            ->distinct(true)
            ->from('usuarios AS u')
            ->where(array('or', 'id=7', 'id=4', 'id=8'))
            ->all();

        //return $rQuery;
        // Mostra detalhes da pesquisa
        return $this->montaQuery;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return password_verify($password, $this->senha);
    }

    public function getUsuarios()
    {
        $query = self::find()
            ->select('cnpj, empresa')
            ->distinct()
//            ->asArray()
            ->all();

        return ArrayHelper::map($query, 'cnpj', 'empresa');
    }
}