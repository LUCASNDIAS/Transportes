<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * This is the model class for table "tabelas".
 *
 * @property integer $id
 * @property string $cridt
 * @property string $criusu
 * @property string $dono
 * @property string $nome
 * @property string $descricao
 * @property string $fretevalor
 * @property string $despacho
 * @property string $seccat
 * @property string $itr
 * @property string $gris
 * @property string $pedagio
 * @property string $outros
 * @property string $valorminimo
 * @property string $pesominimo
 * @property string $excedente
 * @property string $imposto
 */
class Tabelas extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tabelas';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cridt', 'criusu', 'dono', 'nome', 'descricao', 'valorminimo', 'pesominimo', 'excedente'], 'required'],
            [['cridt'], 'safe'],
            [['criusu'], 'string', 'max' => 30],
            [['dono', 'fretevalor', 'despacho', 'seccat', 'itr', 'gris', 'pedagio', 'outros', 'valorminimo', 'pesominimo', 'excedente'], 'string', 'max' => 20],
            [['nome', 'descricao'], 'string', 'max' => 100],
            [['imposto'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'cridt' => Yii::t('app', 'Data de criação'),
            'criusu' => Yii::t('app', 'Usuário'),
            'dono' => Yii::t('app', 'Dono'),
            'nome' => Yii::t('app', 'Nome'),
            'descricao' => Yii::t('app', 'Descrição'),
            'fretevalor' => Yii::t('app', 'Frete Valor (%)'),
            'despacho' => Yii::t('app', 'Despacho (R$)'),
            'seccat' => Yii::t('app', 'Seccat (R$)'),
            'itr' => Yii::t('app', 'Itr (R$)'),
            'gris' => Yii::t('app', 'Gris (%)'),
            'pedagio' => Yii::t('app', 'Pedágio (R$)'),
            'outros' => Yii::t('app', 'Outros (R$)'),
            'valorminimo' => Yii::t('app', 'Valor mínimo (R$)'),
            'pesominimo' => Yii::t('app', 'Peso mínimo (Kg)'),
            'excedente' => Yii::t('app', 'Excedente (R$)'),
            'imposto' => Yii::t('app', 'Incluir Imposto?'),
        ];
    }

    /**
     * listarNomes
     * Retorna array com nome e id da tabela para selecionar nos clientes
     * @return Ambigous <multitype:, multitype:NULL >
     */
    public function listarNomes() {
        //if ($termo != '') {
        $pesquisa = self::find()
                ->select([new \yii\db\Expression("CONCAT( `id`,' | ',`nome`) as nome")])
                ->asArray()
                ->all();

        $value_tabelas = ArrayHelper::getColumn($pesquisa, 'nome', false);

        return $value_tabelas;
        //}
    }

    public function listarTabelas($idTab, $json = true) {
        $pesquisa = self::find()
                ->select([
                    'id' => 'id',
                    'nome' => 'nome'
                ])
                ->where([
                    'in', 'id', $idTab
                ])
                ->asArray()
                ->all();

        if ($json) {
            // retorna o Json
            Yii::$app->response->format = 'json';
            return $pesquisa;            
        } else {
            $array = ArrayHelper::map($pesquisa, 'id', 'nome');
            return $array;
        }
    }

    public function testeAjax() {
        $pesquisa = self::find()
                ->select(['id', 'nome'])
                ->asArray()
                ->all();

        return $pesquisa;
    }

    public function nomeTabelas($tabelasBD) {
        if (!empty($tabelasBD)) {
            // Busca os dados das tabelas e retorna um array
            $idNomes = self::find()
                    ->select([new \yii\db\Expression("CONCAT( `id`,' | ',`nome`) as nome")])
                    ->where(['in', 'id', $tabelasBD])
                    ->asArray()
                    ->all();

            $value_tabelas = ArrayHelper::getColumn($idNomes, 'nome', false);

            return $value_tabelas;
        }
    }

    public function nomeTabela($id) {
        return self::findOne($id);
    }

    public function autoComplete() {

        $data = self::find()
                ->select([new \yii\db\Expression("nome as value, CONCAT( `nome`,' | ',`descricao`) as label, id")])
                ->where(['dono' => Yii::$app->user->identity['cnpj']])
                ->asArray()
                ->all();

        return $data;
    }
    
}
