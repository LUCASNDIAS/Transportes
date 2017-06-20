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
            [['dono', 'cridt', 'criusu', 'chave', 'modelo', 'serie', 'numero', 'dtemissao', 'dtinicio', 'uf', 'tipoemitente', 'modalidade', 'formaemissao', 'ufcarga', 'ufdescarga', 'rntrc', 'ciot', 'placa', 'qtdecte', 'qtdenfe', 'qtdenf', 'valormercadoria', 'unidademedida', 'pesomercadoria', 'inffisco', 'infcontribuinte', 'status'], 'required'],
            [['cridt', 'dtemissao', 'dtinicio'], 'safe'],
            [['qtdecte', 'qtdenfe', 'qtdenf'], 'integer'],
            [['valormercadoria', 'pesomercadoria'], 'number'],
            [['dono', 'criusu'], 'string', 'max' => 14],
            [['chave'], 'string', 'max' => 44],
            [['modelo', 'uf', 'ufcarga', 'ufdescarga'], 'string', 'max' => 2],
            [['serie', 'unidademedida'], 'string', 'max' => 3],
            [['numero'], 'string', 'max' => 9],
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
            'cridt' => Yii::t('app', 'Cridt'),
            'criusu' => Yii::t('app', 'Criusu'),
            'chave' => Yii::t('app', 'Chave'),
            'modelo' => Yii::t('app', 'Modelo'),
            'serie' => Yii::t('app', 'Serie'),
            'numero' => Yii::t('app', 'Numero'),
            'dtemissao' => Yii::t('app', 'Dtemissao'),
            'dtinicio' => Yii::t('app', 'Dtinicio'),
            'uf' => Yii::t('app', 'Uf'),
            'tipoemitente' => Yii::t('app', 'Tipoemitente'),
            'modalidade' => Yii::t('app', 'Modalidade'),
            'formaemissao' => Yii::t('app', 'Formaemissao'),
            'ufcarga' => Yii::t('app', 'Ufcarga'),
            'ufdescarga' => Yii::t('app', 'Ufdescarga'),
            'rntrc' => Yii::t('app', 'Rntrc'),
            'ciot' => Yii::t('app', 'Ciot'),
            'placa' => Yii::t('app', 'Placa'),
            'qtdecte' => Yii::t('app', 'Qtdecte'),
            'qtdenfe' => Yii::t('app', 'Qtdenfe'),
            'qtdenf' => Yii::t('app', 'Qtdenf'),
            'valormercadoria' => Yii::t('app', 'Valormercadoria'),
            'unidademedida' => Yii::t('app', 'Unidademedida'),
            'pesomercadoria' => Yii::t('app', 'Pesomercadoria'),
            'inffisco' => Yii::t('app', 'Inffisco'),
            'infcontribuinte' => Yii::t('app', 'Infcontribuinte'),
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
        return $this->hasMany(MdfeDescarregamento::className(), ['mdfe_id' => 'id']);
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

    /**
     * @inheritdoc
     * @return MdfeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MdfeQuery(get_called_class());
    }
}
