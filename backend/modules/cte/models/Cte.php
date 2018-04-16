<?php

namespace backend\modules\cte\models;

use Yii;
use backend\modules\clientes\models\Clientes;

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
 * @property int $numero
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
 * @property double $pesoreal
 * @property double $pesocubado
 * @property double $taxaextra
 * @property double $desconto
 * @property double $notasvalor
 * @property int $notasvolumes
 * @property int $indietoma
 * @property int $globalizado
 * @property int $ent_nome
 * @property int $ent_rg
 * @property int $ent_data
 * @property int $ent_hora
 * @property string $status
 *
 * @property CteComponentes[] $cteComponentes
 * @property CteDocumentos[] $cteDocumentos
 * @property CteProtocolo[] $cteProtocolos
 * @property CteQtag[] $cteQtags
 * @property CteVeiculo[] $cteVeiculos
 * @property CteMotoristas[] $cteMotoristas
 * @property CteDocants[] $cteDocants
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
            [['dono', 'cridt', 'criusu', 'ambiente', 'chave', 'modelo', 'serie',
                'dtemissao', 'cfop', 'natop', 'forpag', 'tpemis', 'tpcte',
                'cmunenv', 'xmunenv', 'ufenv', 'modal', 'tpserv', 'cmunini',
                'xmunini', 'ufini', 'cmunfim', 'xmunfim', 'uffim', 'retira', 'toma',
                'tomador', 'remetente', 'vtprest', 'vrec', 'dprev', 'prodpred',
                //'cst', 'predbc', 'vbc', 'picms', 'vicms', 'vbcstret',
                //'vicmsret', 'picmsret', 'vcred', 'vtottrib', 'respseg',
                'vcarga', 'rntrc', 'lota', 'tabela_id', 'indietoma','globalizado', 'status'], 'required'],
            [['cridt', 'dtemissao', 'dhcont', 'dprev', 'ent_data'], 'safe'],
            [['ambiente', 'forpag', 'tpemis', 'tpcte', 'tpserv', 'retira', 'toma',
                'numero', 'globalizado',
                'outrauf', 'respseg', 'lota', 'tabela_id', 'notasvolumes', 'indietoma'],
                'integer'],
            [['vtprest', 'vrec', 'predbc', 'vbc', 'picms', 'vicms', 'vbcstret', 'vicmsret',
                'picmsret', 'vcred', 'vtottrib', 'vcarga', 'pesoreal', 'pesocubado',
                'taxaextra', 'desconto', 'notasvalor'], 'number'],
            [['dono', 'criusu', 'tomador', 'remetente', 'destinatario', 'recebedor',
                'expedidor'], 'string', 'max' => 14],
            [['chave', 'refcte'], 'string', 'max' => 44],
            [['modelo', 'ufenv', 'modal', 'ufini', 'uffim', 'cst'], 'string', 'max' => 2],
            [['serie'], 'string', 'max' => 3],
            [['cct'], 'string', 'max' => 8],
            [['cfop'], 'string', 'max' => 4],
            [['ent_hora'], 'string', 'max' => 5],
            [['natop', 'xmunenv', 'xmunini', 'xmunfim', 'xdetretira', 'xjust', 'prodpred',
                'xoutcat', 'xseg'], 'string', 'max' => 60],
            [['cmunenv', 'cmunini', 'cmunfim'], 'string', 'max' => 7],
            [['napol'], 'string', 'max' => 20],
            [['rntrc'], 'string', 'max' => 10],
            [['status', 'ent_nome'], 'string', 'max' => 50],
            [['xcaracad', 'ent_rg'], 'string', 'max' => 15],
            [['xcaracser'], 'string', 'max' => 30],
            [['xobs'], 'string', 'max' => 800],
            [['dprev'], 'match', 'pattern' => '/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})|([0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]))$/'],
            [['prodpred', 'xoutcat'], 'match', 'pattern' => '/^[!-ÿ]{1}[ -ÿ]{0,}[!-ÿ]{1}|[!-ÿ]{1}$/'],
            [['rntrc'], 'match', 'pattern' => '/^[0-9]{8}|ISENTO$/'],
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
            'vrec' => Yii::t('app', 'Valor a Receber'),
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
            'xcaracad' => Yii::t('app', 'Carac. Adicionais'),
            'xcaracser' => Yii::t('app', 'Carac. Serviço'),
            'xobs' => Yii::t('app', 'Observações do emissor'),
            'respseg' => Yii::t('app', 'Seguro Resp.'),
            'xseg' => Yii::t('app', 'Seguradora'),
            'napol' => Yii::t('app', 'Núm. Apólice'),
            'rntrc' => Yii::t('app', 'RNTRC'),
            'dprev' => Yii::t('app', 'Data prevista'),
            'lota' => Yii::t('app', 'Lotação?'),
            'tabela_id' => Yii::t('app', 'Tabela'),
            'pesoreal' => Yii::t('app', 'Peso'),
            'pesocubado' => Yii::t('app', 'Cubado'),
            'taxaextra' => Yii::t('app', 'Taxa extra'),
            'desconto' => Yii::t('app', 'Desconto'),
            'notasvalor' => Yii::t('app', 'R$ Notas'),
            'notasvolumes' => Yii::t('app', 'Volumes'),
            'status' => Yii::t('app', 'Status'),
            'indietoma' => Yii::t('app', 'Indicador IE - Tomador'),
            'globalizado' => Yii::t('app', 'Globalizado'),
            'ent_nome' => Yii::t('app', 'Recebedor'),
            'ent_rg' => Yii::t('app', 'RG'),
            'ent_data' => Yii::t('app', 'Data'),
            'ent_hora' => Yii::t('app', 'Hora'),
            'notaChave' => Yii::t('app', 'Nota fiscal'),
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
        //->from(CteDocumentos::tableName().' documentos');
    }

    public function getNotaChave()
    {
        if ($this->cteDocumentos) {

            $retorno = '';

            // Varre todos os campos
            foreach ($this->cteDocumentos as $i => $nf) {

                if ($i != 0) {
                    $retorno .= '/';
                }

                if (isset($nf->chave[43])) {
                    $retorno .= substr($nf->chave, 25, 9).'';
                } else {
                    $retorno .= $nf->chave.'';
                }
            }

            return $retorno;
        } else {
            return null;
        }
    }

    public function getCteRemetente()
    {
        return $this->hasOne(Clientes::className(), ['cnpj' => 'remetente']);
    }

    public function getCteDestinatario()
    {
        return $this->hasOne(Clientes::className(), ['cnpj' => 'destinatario']);
    }

    public function getCteTomador()
    {
        return $this->hasOne(Clientes::className(), ['cnpj' => 'tomador']);
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
     * @return \yii\db\ActiveQuery
     */
    public function getTabela()
    {
        return $this->hasOne(Tabelas::className(), ['id' => 'tabela_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCteMotoristas()
    {
        return $this->hasMany(CteMotorista::className(), ['cte_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCteDocants()
    {
        return $this->hasMany(CteDocant::className(), ['cte_id' => 'id']);
    }

    public function getLastId($tpAmb)
    {
        $last = self::find()
            ->select(['numero'])
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            ->andWhere(['ambiente' => $tpAmb])
            ->andWhere(['NOT LIKE', 'status', 'DELETADO'])
            ->orderBy('numero DESC')
            ->asArray()
            ->one();

        return (is_null($last)) ? 1 : $last['numero'] + 1;
    }

    public function autocomplete($term = '1')
    {
        $data = self::find()
            ->select([new \yii\db\Expression("chave as value, CONCAT( `numero`,' | ',`ufini`,'/',`uffim`) as label")])
            ->where(['dono' => Yii::$app->user->identity['cnpj']])
            ->andWhere(['LIKE', 'numero', $term])
            ->orderBy('numero')
            ->asArray()
            ->all();

        return $data;
    }

    public function getContratante($chave)
    {
        $data = self::find()
            ->select([
                'contratante' => 'tomador',
                'valor' => 'vcarga',
                'pesoreal' => 'pesoreal',
                'pesocubado' => 'pesocubado',
                'chave' => 'chave'
                ])
            ->where(['numero' => $chave])
            ->andWhere([
                'dono' => \Yii::$app->user->identity['cnpj'],
                'status' => 'AUTORIZADO',
                'ambiente' => 1
                ])
            ->orWhere(['chave' => $chave])
            ->asArray()
            ->all();

        $erro = [['erro' => '1']];
        
        return (empty($data)) ? $erro : $data;
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