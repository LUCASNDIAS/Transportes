<?php

namespace backend\models;

use Yii;
use backend\commands\Basicos;
use yii\web\Request;
/**
 * This is the model class for table "funcionarios".
 *
 * @property integer $id
 * @property string $nome
 * @property string $endrua
 * @property string $endbairro
 * @property string $endcep
 * @property string $endcid
 * @property string $enduf
 * @property string $naturalidade
 * @property string $datanascimento
 * @property string $pai
 * @property string $mae
 * @property string $tel1
 * @property string $tel2
 * @property string $radio
 * @property string $email
 * @property string $rg
 * @property string $cpf
 * @property string $cnhnum
 * @property string $cnhcat
 * @property string $cnhval
 * @property string $pis
 * @property string $cargo
 * @property string $salario
 * @property string $dtentrada
 * @property string $criusu
 * @property string $cridt
 * @property string $img
 */
class Funcionarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'funcionarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'datanascimento', 'cpf', 'cnhnum', 'cnhcat', 'cnhval', 'cargo', 'criusu', 'cridt', 'dono'], 'required'],
            [['datanascimento', 'cnhval', 'dtentrada', 'cridt'], 'safe'],
            [['nome', 'endrua', 'pai', 'mae', 'email'], 'string', 'max' => 200],
            [['endbairro', 'endcid', 'naturalidade', 'cargo', 'criusu'], 'string', 'max' => 100],
            [['endcep', 'endnro'], 'string', 'max' => 10],
            [['enduf', 'rg', 'salario', 'dono'], 'string', 'max' => 20],
            [['tel1', 'tel2'], 'string', 'max' => 15],
            [['radio', 'cnhnum', 'pis'], 'string', 'max' => 30],
            [['cnhcat'], 'string', 'max' => 5],
        	[['img'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        	[['cpf'], 'string', 'max'=>11],
        	['cpf', 'match', 'pattern' => '/^([0-9]{11})$/'],
        	[['email'], 'email', 'skipOnEmpty' => true],
        	[['datanascimento', 'cnhval'], 'match', 'pattern' => '/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/'],
        ];
    }
    
    /**
     * Função para upload de Imagens
     * @return boolean
     */
    public function upload()
    {
    	if ($this->validate()) {
    		//$this->img->saveAs('img/funcionarios' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
    		$this->img->saveAs('img/funcionarios/' . $this->cpf . '.' . $this->img->extension);
    		return true;
    	} else {
    		return false;
    	}
    }
    
    public function beforeSave($insert)
    {
    	$basicos = new Basicos();
    	
    	if (parent::beforeSave($insert)) {
    		$this->datanascimento = $basicos->formataData('db',$this->datanascimento);
    		$this->cnhval = $basicos->formataData('db',$this->cnhval);
    		$this->email = strtolower($this->email);
    		return true;
    	} else {
    		return false;
    	}
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
        	'dono' => Yii::t('app', 'Dono'),
            'nome' => Yii::t('app', 'Nome'),
            'endrua' => Yii::t('app', 'Rua'),
        	'endnro' => Yii::t('app', 'Número'),
            'endbairro' => Yii::t('app', 'Bairro'),
            'endcep' => Yii::t('app', 'CEP'),
            'endcid' => Yii::t('app', 'Cidade'),
            'enduf' => Yii::t('app', 'UF'),
            'naturalidade' => Yii::t('app', 'Naturalidade'),
            'datanascimento' => Yii::t('app', 'Data de Nascimento'),
            'pai' => Yii::t('app', 'Filiação - Pai'),
            'mae' => Yii::t('app', 'Filiação - Mãe'),
            'tel1' => Yii::t('app', 'Telefone'),
            'tel2' => Yii::t('app', 'Telefone'),
            'radio' => Yii::t('app', 'Telefone'),
            'email' => Yii::t('app', 'E-mail'),
            'rg' => Yii::t('app', 'RG'),
            'cpf' => Yii::t('app', 'CPF'),
            'cnhnum' => Yii::t('app', 'Nº CNH'),
            'cnhcat' => Yii::t('app', 'Categoria CNH'),
            'cnhval' => Yii::t('app', 'Validade CNH'),
            'pis' => Yii::t('app', 'PIS'),
            'cargo' => Yii::t('app', 'Cargo'),
            'salario' => Yii::t('app', 'Salário'),
            'dtentrada' => Yii::t('app', 'Data Contratação'),
            'criusu' => Yii::t('app', 'Criador'),
            'cridt' => Yii::t('app', 'Data Criação'),
            'img' => Yii::t('app', 'Foto'),
        ];
    }
    
    /**
     * Função para retornar strings para as GRIDS
     * @param string $tipo
     * @return string
     */
    public function stringDataGrid($tipo = 'telefone')
    {
    	$basicos = new Basicos();
    	
    	// Endereço Completo
    	$Endcompleto = $this->endrua . ', ' . $this->endnro . ', ' . $this->endbairro .
    	' - ' . $this->endcid . ' / ' . $this-> enduf . "  CEP: " . $this->endcep;
    
    	// telefones e radio
    	$telefone = $this->tel1 . ' | ' . $this->tel2 . ' | ' . $this->radio;
    	
    	$cnh = 'Registro: ' . $this->cnhnum . 
    	' - Categoria: ' . $this->cnhcat . 
    	' - Validade: ' . $basicos->formataData('ver',$this->cnhval);
    	 
    	switch ($tipo){
    		case 'telefone':
    			return $telefone;
    			break;
    		case 'endereco':
    			return $Endcompleto;
    			break;
    		case 'cnh':
    			return $cnh;
    			break;
    		default:
    			return $Endcompleto;
    	}
    	 
    }
}
