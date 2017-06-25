<?php

namespace backend\modules\mdfe\models;

use Yii;

/**
 * This is the model class for table "mdfe".
 *
 * @property int $id
 * @property string $dono
 * @property string $cridt
 * @property string $criusu
 * @property string $ambiente
 * @property string $chave
 * @property string $modelo
 * @property string $serie
 * @property string $numero
 * @property string $dtemissao
 * @property string $dtinicio
 * @property string $uf
 * @property string $tipoemitente
 * @property string $modalidade
 * @property string $formaemissao
 * @property string $ufcarga
 * @property string $ufdescarga
 * @property string $rntrc
 * @property string $ciot
 * @property string $placa
 * @property int $qtdecte
 * @property int $qtdenfe
 * @property int $qtdenf
 * @property double $valormercadoria
 * @property string $unidademedida
 * @property double $pesomercadoria
 * @property string $inffisco
 * @property string $infcontribuinte
 * @property string $status
 *
 * @property MdfeCarregamento[] $mdfeCarregamentos
 * @property MdfeCondutor[] $mdfeCondutors
 * @property MdfeDescarregamento[] $mdfeDescarregamentos
 * @property MdfeDocumentos[] $mdfeDocumentos
 * @property MdfePercurso[] $mdfePercursos
 */
class Mdfe extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mdfe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dono', 'cridt', 'criusu', 'chave', 'modelo', 'serie', 'dtemissao', 'ambiente',
                'uf', 'tipoemitente', 'modalidade', 'formaemissao', 'ufcarga', 'ufdescarga',
                'placa', 'qtdecte', 'valormercadoria', 'unidademedida', 'pesomercadoria'],
                'required'],
            [['cridt', 'dtemissao', 'dtinicio'], 'safe'],
            [['qtdecte', 'qtdenfe', 'qtdenf'], 'integer'],
            [['valormercadoria', 'pesomercadoria'], 'number'],
            [['dono', 'criusu'], 'string', 'max' => 14],
            [['chave'], 'string', 'max' => 44],
            [['modelo', 'uf', 'ufcarga', 'ufdescarga'], 'string', 'max' => 2],
            [['serie', 'unidademedida'], 'string', 'max' => 3],
            [['tipoemitente'], 'string', 'max' => 50],
            [['modalidade', 'formaemissao', 'rntrc', 'ciot'], 'string', 'max' => 20],
            [['placa'], 'string', 'max' => 8],
            [['inffisco', 'infcontribuinte'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'dono' => Yii::t('app', 'Dono'),
            'cridt' => Yii::t('app', 'Data Criação'),
            'criusu' => Yii::t('app', 'Usuário Criador'),
            'ambiente' => Yii::t('app', 'Ambiente'),
            'chave' => Yii::t('app', 'Chave'),
            'modelo' => Yii::t('app', 'Modelo'),
            'serie' => Yii::t('app', 'Série'),
            'numero' => Yii::t('app', 'Número'),
            'dtemissao' => Yii::t('app', 'Data Emissão'),
            'dtinicio' => Yii::t('app', 'Inicio Viagem'),
            'uf' => Yii::t('app', 'UF'),
            'tipoemitente' => Yii::t('app', 'Tipo de Emitente'),
            'modalidade' => Yii::t('app', 'Modalidade'),
            'formaemissao' => Yii::t('app', 'Forma de emissão'),
            'ufcarga' => Yii::t('app', 'UF de Carga'),
            'ufdescarga' => Yii::t('app', 'UF de Descarga'),
            'rntrc' => Yii::t('app', 'RNTRC'),
            'ciot' => Yii::t('app', 'CIOT'),
            'placa' => Yii::t('app', 'Placa'),
            'qtdecte' => Yii::t('app', 'Qtde CT-e'),
            'qtdenfe' => Yii::t('app', 'Qtde NF-e'),
            'qtdenf' => Yii::t('app', 'Qtde NF'),
            'valormercadoria' => Yii::t('app', 'Valor mercadoria'),
            'unidademedida' => Yii::t('app', 'Unidade de medida'),
            'pesomercadoria' => Yii::t('app', 'Peso'),
            'inffisco' => Yii::t('app', 'Informações ao Fisco'),
            'infcontribuinte' => Yii::t('app', 'Informações do Contribuinte'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdfeCarregamentos()
    {
        return $this->hasMany(MdfeCarregamento::className(), ['mdfe_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdfeCondutors()
    {
        return $this->hasMany(MdfeCondutor::className(), ['mdfe_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdfeDescarregamentos()
    {
        return $this->hasMany(MdfeDescarregamento::className(),
                ['mdfe_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdfeDocumentos()
    {
        return $this->hasMany(MdfeDocumentos::className(), ['mdfe_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMdfePercursos()
    {
        return $this->hasMany(MdfePercurso::className(), ['mdfe_id' => 'id']);
    }

    public function getLastId($tpAmb)
    {
        $last = self::find()
            ->select(['numero'])
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            ->andWhere(['ambiente' => $tpAmb])
            ->orderBy('numero DESC')
            ->asArray()
            ->one();

        return (is_null($last)) ? 1 : $last['numero'] + 1;
    }

    /**
     * @inheritdoc
     * @return MdfeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MdfeQuery(get_called_class());
    }
}