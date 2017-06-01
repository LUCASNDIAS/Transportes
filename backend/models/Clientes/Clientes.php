<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use app\components\ClienteValidator;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "clientes".
 *
 * @property integer $id
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
 * @property string $responsaveis
 * @property string $telefones
 * @property string $emails
 * @property string $tabelas
 * @property string $status
 */
class Clientes extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'clientes';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cridt', 'criusu', 'dono', 'nome', 'ie', 'cnpj', 'endrua', 'endnro', 'endbairro', 'endcid', 'enduf', 'endcep', 'status'], 'required'],
            [['cridt', 'criusu', 'dono', 'nome', 'ie', 'cnpj', 'endrua', 'endnro', 'endbairro', 'endcid', 'enduf', 'endcep', 'status', 'telefones'], 'trim'],
            [['cridt'], 'safe'],
            //['cnpj', 'unique', 'message' => 'Já existente'],
            [['criusu'], 'string', 'max' => 30],
            [['dono', 'ie'], 'string', 'max' => 20],
            [['cnpj'], 'string', 'max' => 14],
            [['nome', 'endrua'], 'string', 'max' => 100],
            [['endnro', 'endcep', 'status'], 'string', 'max' => 10],
            [['endbairro'], 'string', 'max' => 50],
            [['endcid'], 'string', 'max' => 80],
            [['endcep'], 'string', 'max' => 9],
            [['enduf'], 'string', 'max' => 2],
            [['responsaveis', 'telefones', 'tabelas'], 'string', 'max' => 500],
            [['emails'], 'string', 'max' => 700],
            ['cnpj', 'match', 'pattern' => '/^([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})$/'],
            [['nome', 'endnro', 'endbairro', 'endrua', 'endcid'], 'match', 'pattern' => '/^([!-ÿ]{1}[ -ÿ]{0,}[!-ÿ]{1}|[!-ÿ]{1})$/'],
            ['ie', 'match', 'pattern' => '/^(ISENTO|[0-9]{0,14})$/'],
            //['endcep', 'match', 'pattern' => '/^([0-9]{8})$/'],
            ['cnpj', ClienteValidator::className(),
                'when' => function ($model) {
                    return $model->isNewRecord;
                }
            ],
                //['tabelas', 'required', 'when' => function ($model) {
                //	return $model->dono == 'asdfasdfsdaf';
                //}, 'whenClient' => "function (attribute, value) {
                //	return $('#dono').val() == 'asdfasdfsdaf';
                //}"],
                //['tabelas', CountryValidator::className()],
                //['telefones', 'match', 'pattern' => '/^([(]?[0-9]{2}[)]?[0-9]{4,5}[-]?[0-9]{4,5})$/'],
                //['emails', 'email'],
        ];
    }

    public function retornaCliente($cnpj) {
        $query = self::find()
                ->where(['dono' => Yii::$app->user->identity['cnpj']])
                ->andWhere(['cnpj' => $cnpj])
                ->one();

        return $query;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cridt' => 'Data de Criação',
            'criusu' => 'Apelido criador',
            'dono' => 'CNPJ criador',
            'nome' => 'Nome',
            'cnpj' => 'CNPJ ou CPF',
            'ie' => 'I.E.',
            'endrua' => 'Logradouro',
            'endnro' => 'Número',
            'endbairro' => 'Bairro',
            'endcid' => 'Cidade',
            'enduf' => 'UF',
            'endcep' => 'CEP',
            'responsaveis' => 'Responsável',
            'telefones' => 'Telefone',
            'emails' => 'Email',
            'tabelas' => 'Tabelas',
            'status' => 'Status',
        ];
    }

    public function Tabelas($cnpj) {
        $tabelas = self::find()
                ->select('tabelas')
                ->where([
                    'cnpj' => $cnpj
                ])
                ->asArray()
                ->one();

        //$array = explode('|', $tabelas['tabelas']);
        $array = array_unique(preg_split('/\|/', $tabelas['tabelas'], -1, PREG_SPLIT_NO_EMPTY));

        return $array;
    }

    public function getEmail($cnpj) {
        $email = self::find()
                ->select('emails')
                ->where(['dono' => Yii::$app->user->identity['cnpj']])
                ->andWhere(['cnpj' => $cnpj])
                ->one();

        $array = array_unique(preg_split('/\|/', $email['emails'], -1, PREG_SPLIT_NO_EMPTY));

        return $array;
    }

    public function getNome($cnpj) {
        $nome = self::find()
                ->select('nome')
                ->where(['dono' => Yii::$app->user->identity['cnpj']])
                ->andWhere(['cnpj' => $cnpj])
                ->one();

        return $nome['nome'];
    }

    public function Cidades($clientes) {
        $pesquisa = self::find()
                ->select([
                    'endcid' => 'endcid',
                    'enduf' => 'enduf'
                ])
                ->where([
                    'in', 'cnpj', $clientes
                ])
                ->andWhere([
                    'dono' => Yii::$app->user->identity['cnpj']
                ])
                ->asArray()
                ->all();

        // $array = ArrayHelper::map($pesquisa, 'endcid', 'enduf');
        return $pesquisa;
    }

    /**
     * Função para retornar strings para as GRIDS
     * @param string $tipo
     * @return string
     */
    public function stringDataGrid($tipo = 'telefone') {
        // Endereço Completo
        $Endcompleto = $this->endrua . ', ' . $this->endnro . ', ' . $this->endbairro .
                ' - ' . $this->endcid . ' / ' . $this->enduf . "  CEP: " . $this->endcep;

        // Retorna o Primeiro telefone informado
        $separatel = explode('|', $this->telefones);
        $telefone = ($separatel[0] == '') ? '---' : $separatel[0];

        // Separa os Dados por contato
        $telefones = explode('|', $this->telefones);
        $responsaveis = explode('|', $this->responsaveis);
        $emails = explode('|', $this->emails);

        $i = 0;
        $contatoLinha = '';
        foreach ($responsaveis as $responsavel) {
            if ($responsavel != '') {
                $contatoLinha .= $responsavel . ' => ' . $telefones[$i] . ' => ' . $emails[$i] . " \n\n ";
            }
            $i++;
        }

        $contato = ($contatoLinha != '') ? $contatoLinha : 'Nenhum contato informado.';

        switch ($tipo) {
            case 'telefone':
                return $telefone;
                break;
            case 'endereco':
                return $Endcompleto;
                break;
            case 'contato':
                return $contato;
                break;
            default:
                return $telefone;
        }
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientesContatos()
    {
        return $this->hasMany(ClientesContatos::className(), ['clientes_id' => 'id']);
    }

    public function autoComplete() {

        $data = self::find()
                ->select([new \yii\db\Expression("nome as value, CONCAT( `nome`,' | ',`cnpj`) as label, cnpj, endcid")])
                ->where(['dono' => Yii::$app->user->identity['cnpj']])
                ->asArray()
                ->all();

        return $data;
    }

}
