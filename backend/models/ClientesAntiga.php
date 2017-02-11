<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "clientes".
 *
 * @property integer $id
 * @property string $cridt
 * @property string $criusu
 * @property string $nome
 * @property string $cnpj
 * @property string $cnpj2
 * @property string $ie
 * @property string $endrua
 * @property string $endbairro
 * @property string $endcid
 * @property string $enduf
 * @property string $cep
 * @property string $resp1
 * @property string $resp2
 * @property string $resp3
 * @property string $tel1
 * @property string $tel2
 * @property string $tel3
 * @property string $email1
 * @property string $email2
 * @property string $email3
 * @property string $idtab
 * @property string $tab1
 * @property string $tab2
 * @property string $tab3
 * @property string $tab4
 * @property string $tab5
 * @property string $tab6
 * @property string $tab7
 * @property string $tab8
 * @property string $tab9
 * @property string $tab10
 * @property string $tab11
 * @property string $tab12
 * @property string $tab13
 * @property string $tab14
 * @property string $tab15
 * @property string $tab16
 * @property string $tab17
 * @property string $tab18
 * @property string $tab19
 * @property string $tab20
 * @property string $tab21
 * @property string $tab22
 * @property string $tab23
 * @property string $tab24
 * @property string $tab25
 * @property string $tab26
 * @property string $tab27
 * @property string $tab28
 * @property string $tab29
 * @property string $tab30
 */
class ClientesAntiga extends \yii\db\ActiveRecord
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
            [['cridt', 'criusu', 'nome', 'cnpj', 'cnpj2', 'ie', 'endrua', 'endbairro', 'endcid', 'enduf', 'cep', 'resp1', 'resp2', 'resp3', 'tel1', 'tel2', 'tel3', 'email1', 'email2', 'email3', 'idtab', 'tab1', 'tab2', 'tab3', 'tab4', 'tab5', 'tab6', 'tab7', 'tab8', 'tab9', 'tab10', 'tab11', 'tab12', 'tab13', 'tab14', 'tab15', 'tab16', 'tab17', 'tab18', 'tab19', 'tab20', 'tab21', 'tab22', 'tab23', 'tab24', 'tab25', 'tab26', 'tab27', 'tab28', 'tab29', 'tab30'], 'required'],
            [['cridt'], 'safe'],
            [['criusu', 'idtab', 'tab1', 'tab2', 'tab3', 'tab4', 'tab5', 'tab6', 'tab7', 'tab8', 'tab9', 'tab10', 'tab11', 'tab12', 'tab13', 'tab14', 'tab15', 'tab16', 'tab17', 'tab18', 'tab19', 'tab20', 'tab21', 'tab22', 'tab23', 'tab24', 'tab25', 'tab26', 'tab27', 'tab28', 'tab29', 'tab30'], 'string', 'max' => 100],
            [['nome', 'endrua', 'endbairro', 'endcid', 'resp1', 'resp2', 'resp3', 'email1', 'email2', 'email3'], 'string', 'max' => 200],
            [['cnpj', 'ie'], 'string', 'max' => 30],
            [['cnpj2'], 'string', 'max' => 15],
            [['enduf', 'cep'], 'string', 'max' => 10],
            [['tel1', 'tel2', 'tel3'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cridt' => 'Cridt',
            'criusu' => 'Criusu',
            'nome' => 'Nome',
            'cnpj' => 'Cnpj',
            'cnpj2' => 'Cnpj2',
            'ie' => 'Ie',
            'endrua' => 'Endrua',
            'endbairro' => 'Endbairro',
            'endcid' => 'Endcid',
            'enduf' => 'Enduf',
            'cep' => 'Cep',
            'resp1' => 'Resp1',
            'resp2' => 'Resp2',
            'resp3' => 'Resp3',
            'tel1' => 'Tel1',
            'tel2' => 'Tel2',
            'tel3' => 'Tel3',
            'email1' => 'Email1',
            'email2' => 'Email2',
            'email3' => 'Email3',
            'idtab' => 'Idtab',
            'tab1' => 'Tab1',
            'tab2' => 'Tab2',
            'tab3' => 'Tab3',
            'tab4' => 'Tab4',
            'tab5' => 'Tab5',
            'tab6' => 'Tab6',
            'tab7' => 'Tab7',
            'tab8' => 'Tab8',
            'tab9' => 'Tab9',
            'tab10' => 'Tab10',
            'tab11' => 'Tab11',
            'tab12' => 'Tab12',
            'tab13' => 'Tab13',
            'tab14' => 'Tab14',
            'tab15' => 'Tab15',
            'tab16' => 'Tab16',
            'tab17' => 'Tab17',
            'tab18' => 'Tab18',
            'tab19' => 'Tab19',
            'tab20' => 'Tab20',
            'tab21' => 'Tab21',
            'tab22' => 'Tab22',
            'tab23' => 'Tab23',
            'tab24' => 'Tab24',
            'tab25' => 'Tab25',
            'tab26' => 'Tab26',
            'tab27' => 'Tab27',
            'tab28' => 'Tab28',
            'tab29' => 'Tab29',
            'tab30' => 'Tab30',
        ];
    }
    
    public function verTodos()
    {
    	$query = self::find()->orderBy('id ASC')->all();

    	return $query;
    }
}
