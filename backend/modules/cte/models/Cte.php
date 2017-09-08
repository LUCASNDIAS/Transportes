<?php

namespace backend\modules\cte\models;

use Yii;

/**
 * This is the model class for table "cte".
 *
 * @property int $id
 * @property string $dono
 * @property string $cridt
 * @property string $criusu
 * @property int $ambiente
 * @property string $chave
 * @property string $modelo
 * @property string $serie
 * @property string $numero
 * @property string $dtemissao
 * @property string $cct
 * @property string $cfop
 * @property string $natop
 * @property int $forpag
 * @property int $tpemis
 * @property int $tpcte
 * @property string $refcte
 * @property string $cmunenv
 * @property string $xmunenv
 * @property string $ufenv
 * @property string $modal
 * @property int $tpserv
 * @property string $cmunini
 * @property string $xmunini
 * @property string $ufini
 * @property string $cmunfim
 * @property string $xmunfim
 * @property string $uffim
 * @property int $retira
 * @property string $xdetretira
 * @property string $dhcont
 * @property string $xjust
 * @property int $toma
 * @property string $tomador
 * @property string $remetente
 * @property string $destinatario
 * @property string $recebedor
 * @property string $expedidor
 * @property double $vtprest
 * @property double $vrec
 * @property string $cst
 * @property double $predbc
 * @property double $vbc
 * @property double $picms
 * @property double $vicms
 * @property double $vbcstret
 * @property double $vicmsret
 * @property double $picmsret
 * @property double $vcred
 * @property double $vtottrib
 * @property int $outrauf
 * @property double $vcarga
 * @property string $prodpred
 * @property string $xoutcat
 * @property int $respseg
 * @property string $xseg
 * @property string $napol
 * @property string $rntrc
 * @property string $dprev
 * @property int $lota
 * @property int $tabela_id
 * @property string $status
 *
 * @property CteComponentes[] $cteComponentes
 * @property CteDocumentos[] $cteDocumentos
 * @property CteProtocolo[] $cteProtocolos
 * @property CteQtag[] $cteQtags
 * @property CteVeiculo[] $cteVeiculos
 */
class Cte extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cte';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dono', 'cridt', 'criusu', 'ambiente', 'chave', 'modelo', 'serie', 'dtemissao', 'cct', 'cfop', 'natop', 'forpag', 'tpemis', 'tpcte', 'refcte', 'cmunenv', 'xmunenv', 'ufenv', 'modal', 'tpserv', 'cmunini', 'xmunini', 'ufini', 'cmunfim', 'xmunfim', 'uffim', 'retira', 'toma', 'tomador', 'remetente', 'destinatario', 'recebedor', 'expedidor', 'vtprest', 'vrec', 'cst', 'predbc', 'vbc', 'picms', 'vicms', 'vbcstret', 'vicmsret', 'picmsret', 'vcred', 'vtottrib', 'vcarga', 'respseg', 'rntrc', 'lota', 'tabela_id', 'status'], 'required'],
            [['cridt', 'dtemissao', 'dhcont', 'dprev'], 'safe'],
            [['ambiente', 'forpag', 'tpemis', 'tpcte', 'tpserv', 'retira', 'toma', 'outrauf', 'respseg', 'lota', 'tabela_id'], 'integer'],
            [['vtprest', 'vrec', 'predbc', 'vbc', 'picms', 'vicms', 'vbcstret', 'vicmsret', 'picmsret', 'vcred', 'vtottrib', 'vcarga'], 'number'],
            [['dono', 'criusu', 'tomador', 'remetente', 'destinatario', 'recebedor', 'expedidor'], 'string', 'max' => 14],
            [['chave', 'refcte'], 'string', 'max' => 44],
            [['modelo', 'ufenv', 'modal', 'ufini', 'uffim', 'cst'], 'string', 'max' => 2],
            [['serie'], 'string', 'max' => 3],
            [['numero'], 'string', 'max' => 9],
            [['cct'], 'string', 'max' => 8],
            [['cfop'], 'string', 'max' => 4],
            [['natop', 'xmunenv', 'xmunini', 'xmunfim', 'xdetretira', 'xjust', 'prodpred', 'xoutcat', 'xseg'], 'string', 'max' => 60],
            [['cmunenv', 'cmunini', 'cmunfim'], 'string', 'max' => 7],
            [['napol'], 'string', 'max' => 20],
            [['rntrc'], 'string', 'max' => 10],
            [['status'], 'string', 'max' => 50],
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
            'criusu' => Yii::t('app', 'Usuário'),
            'ambiente' => Yii::t('app', 'Ambiente'),
            'chave' => Yii::t('app', 'Chave'),
            'modelo' => Yii::t('app', 'Modelo'),
            'serie' => Yii::t('app', 'Série'),
            'numero' => Yii::t('app', 'Número'),
            'dtemissao' => Yii::t('app', 'Emissão'),
            'cct' => Yii::t('app', 'CCT'),
            'cfop' => Yii::t('app', 'CFOP'),
            'natop' => Yii::t('app', 'Nat. Operação'),
            'forpag' => Yii::t('app', 'Pagamento'),
            'tpemis' => Yii::t('app', 'Tipo Emissão'),
            'tpcte' => Yii::t('app', 'Tipo CTe'),
            'refcte' => Yii::t('app', 'Cte ref.'),
            'cmunenv' => Yii::t('app', 'Cód. Mun'),
            'xmunenv' => Yii::t('app', 'Município'),
            'ufenv' => Yii::t('app', 'UF'),
            'modal' => Yii::t('app', 'Modal'),
            'tpserv' => Yii::t('app', 'Tipo Serviço'),
            'cmunini' => Yii::t('app', 'Cód. Mun'),
            'xmunini' => Yii::t('app', 'Município'),
            'ufini' => Yii::t('app', 'UF'),
            'cmunfim' => Yii::t('app', 'Cód. Mun'),
            'xmunfim' => Yii::t('app', 'Município'),
            'uffim' => Yii::t('app', 'UF'),
            'retira' => Yii::t('app', 'Retira'),
            'xdetretira' => Yii::t('app', 'Detalhes'),
            'dhcont' => Yii::t('app', 'Contingência D/H'),
            'xjust' => Yii::t('app', 'Justificativa'),
            'toma' => Yii::t('app', 'Toma'),
            'tomador' => Yii::t('app', 'Tomador'),
            'remetente' => Yii::t('app', 'Remetente'),
            'destinatario' => Yii::t('app', 'Destinatário'),
            'recebedor' => Yii::t('app', 'Recebedor'),
            'expedidor' => Yii::t('app', 'Expedidor'),
            'vtprest' => Yii::t('app', 'Total'),
            'vrec' => Yii::t('app', 'Recebido'),
            'cst' => Yii::t('app', 'Classificação'),
            'predbc' => Yii::t('app', '% Redução'),
            'vbc' => Yii::t('app', 'R$ Base calc.'),
            'picms' => Yii::t('app', 'Aliq. ICMS'),
            'vicms' => Yii::t('app', 'R$ ICMS'),
            'vbcstret' => Yii::t('app', 'R$ BC retido'),
            'vicmsret' => Yii::t('app', 'R$ ICMS retido'),
            'picmsret' => Yii::t('app', '% ICMS retido'),
            'vcred' => Yii::t('app', 'R$ outorgado'),
            'vtottrib' => Yii::t('app', 'Total Tributos'),
            'outrauf' => Yii::t('app', 'Outrauf'),
            'vcarga' => Yii::t('app', 'Valor Carga'),
            'prodpred' => Yii::t('app', 'Prod. predominante'),
            'xoutcat' => Yii::t('app', 'Outras características'),
            'respseg' => Yii::t('app', 'Seguro Resp.'),
            'xseg' => Yii::t('app', 'Seguradora'),
            'napol' => Yii::t('app', 'Núm. Apólice'),
            'rntrc' => Yii::t('app', 'RNTRC'),
            'dprev' => Yii::t('app', 'Data prevista'),
            'lota' => Yii::t('app', 'Lotação?'),
            'tabela_id' => Yii::t('app', 'Tabela'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCteComponentes()
    {
        return $this->hasMany(CteComponentes::className(), ['cte_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCteDocumentos()
    {
        return $this->hasMany(CteDocumentos::className(), ['cte_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCteProtocolos()
    {
        return $this->hasMany(CteProtocolo::className(), ['cte_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCteQtags()
    {
        return $this->hasMany(CteQtag::className(), ['cte_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCteVeiculos()
    {
        return $this->hasMany(CteVeiculo::className(), ['cte_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CteQuery(get_called_class());
    }
}
