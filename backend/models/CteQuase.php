<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cte".
 *
 * @property int $id
 * @property string $cridt
 * @property string $criusu
 * @property string $dono
 * @property int $infCTe_chave
 * @property int $infCTe_versao
 * @property string $ide_cUF
 * @property string $ide_cCT
 * @property string $ide_CFOP
 * @property string $ide_natOp
 * @property string $ide_forPag
 * @property string $ide_mod
 * @property string $ide_serie
 * @property string $ide_nCT
 * @property string $ide_dhEmi
 * @property string $ide_tpImp
 * @property string $ide_tpEmis
 * @property int $ide_cDV
 * @property int $ide_tpAmb
 * @property string $ide_tpCTe
 * @property string $ide_procEmi
 * @property string $ide_verProc
 * @property int $ide_refCTe
 * @property string $ide_cMunEnv
 * @property string $ide_xMunEnv
 * @property string $ide_UFEnv
 * @property string $ide_modal
 * @property string $ide_tpServ
 * @property int $ide_cMunIni
 * @property string $ide_xMunIni
 * @property string $ide_UFIni
 * @property string $ide_cMunFim
 * @property string $ide_xMunFim
 * @property string $ide_UFFim
 * @property string $ide_retira
 * @property string $ide_xDetRetira
 * @property string $ide_dhCont
 * @property string $ide_xJust
 * @property string $toma
 * @property string $tomador
 * @property string $emitente
 * @property string $remetente
 * @property string $destinatario
 * @property string $expedidor
 * @property string $recebedor
 * @property double $vPrest_vTPrest
 * @property double $vPrest_vRec
 * @property string $comp_xNome
 * @property double $comp_vComp
 * @property string $icms
 * @property double $infCarga
 * @property string $infQ_cUnid
 * @property string $infQ_tpMed
 * @property double $infQ_qCarga
 * @property int $infNFe
 * @property string $infNF
 * @property string $seguro
 * @property string $infModal_versaoModal
 * @property string $rodo
 * @property string $veiculo
 * @property string $motorista
 * @property string $pathXML
 * @property string $pathPDF
 * @property string $entrega_data
 * @property string $entrega_hora
 * @property string $entrega_nome
 * @property string $entrega_doc
 * @property string $status
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
//            [['cridt', 'criusu', 'dono', 'infCTe_chave', 'infCTe_versao', 'ide_cUF', 'ide_cCT', 'ide_CFOP', 'ide_natOp', 'ide_forPag', 'ide_mod', 'ide_serie', 'ide_nCT', 'ide_dhEmi', 'ide_tpImp', 'ide_tpEmis', 'ide_cDV', 'ide_tpAmb', 'ide_tpCTe', 'ide_procEmi', 'ide_verProc', 'ide_refCTe', 'ide_cMunEnv', 'ide_xMunEnv', 'ide_UFEnv', 'ide_modal', 'ide_tpServ', 'ide_cMunIni', 'ide_xMunIni', 'ide_UFIni', 'ide_cMunFim', 'ide_xMunFim', 'ide_UFFim', 'ide_retira', 'ide_xDetRetira', 'ide_dhCont', 'ide_xJust', 'toma', 'tomador', 'emitente', 'remetente', 'destinatario', 'vPrest_vTPrest', 'vPrest_vRec', 'comp_xNome', 'comp_vComp', 'icms', 'infCarga', 'infQ_cUnid', 'infQ_tpMed', 'infQ_qCarga', 'infNFe', 'infNF', 'seguro', 'infModal_versaoModal', 'rodo', 'veiculo', 'motorista', 'pathXML', 'pathPDF', 'entrega_data', 'entrega_hora', 'entrega_nome', 'entrega_doc', 'status'], 'required'],
//            [['cridt', 'ide_dhEmi', 'ide_dhCont', 'entrega_data'], 'safe'],
//            [['infCTe_chave', 'infCTe_versao', 'ide_cDV', 'ide_tpAmb', 'ide_refCTe', 'ide_cMunIni', 'infNFe'], 'integer'],
//            [['vPrest_vTPrest', 'vPrest_vRec', 'comp_vComp', 'infCarga', 'infQ_qCarga'], 'number'],
//            [['criusu', 'ide_xMunEnv', 'ide_xMunIni', 'ide_xMunFim', 'ide_xDetRetira', 'comp_xNome'], 'string', 'max' => 50],
//            [['dono', 'tomador', 'emitente', 'remetente', 'destinatario'], 'string', 'max' => 14],
//            [['ide_cUF', 'ide_UFEnv', 'ide_modal', 'ide_UFIni', 'ide_UFFim', 'icms', 'infQ_cUnid'], 'string', 'max' => 2],
//            [['ide_cCT', 'ide_nCT'], 'string', 'max' => 8],
//            [['ide_CFOP', 'ide_mod', 'ide_serie'], 'string', 'max' => 4],
//            [['ide_natOp'], 'string', 'max' => 60],
//            [['ide_forPag', 'ide_tpImp', 'ide_tpEmis', 'ide_tpCTe', 'ide_procEmi', 'ide_tpServ', 'ide_retira', 'toma', 'seguro'], 'string', 'max' => 1],
//            [['ide_verProc', 'infModal_versaoModal'], 'string', 'max' => 10],
//            [['ide_cMunEnv', 'ide_cMunFim'], 'string', 'max' => 7],
//            [['ide_xJust', 'pathXML', 'pathPDF'], 'string', 'max' => 100],
//            [['infQ_tpMed'], 'string', 'max' => 20],
//            [['infNF', 'rodo', 'entrega_doc'], 'string', 'max' => 15],
//            [['veiculo'], 'string', 'max' => 12],
//            [['motorista'], 'string', 'max' => 11],
//            [['entrega_hora'], 'string', 'max' => 5],
//            [['entrega_nome', 'status'], 'string', 'max' => 30],
        ];
    }
    
    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {
            var_dump(Yii::$app->request->post('notasnumerox'));
        } else {
            var_dump(Yii::$app->request->post());
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cridt' => Yii::t('app', 'Data de criação'),
            'criusu' => Yii::t('app', 'Usuário'),
            'dono' => Yii::t('app', 'Dono'),
            'infCTe_chave' => Yii::t('app', 'Chave'),
            'infCTe_versao' => Yii::t('app', 'Versão CTe'),
            'ide_cUF' => Yii::t('app', 'UF'),
            'ide_cCT' => Yii::t('app', 'Controle'),
            'ide_CFOP' => Yii::t('app', 'CFOP'),
            'ide_natOp' => Yii::t('app', 'Natureza Operação'),
            'ide_forPag' => Yii::t('app', 'Forma de Pagamento'),
            'ide_mod' => Yii::t('app', 'Modelo'),
            'ide_serie' => Yii::t('app', 'Série'),
            'ide_nCT' => Yii::t('app', 'Nº Controle'),
            'ide_dhEmi' => Yii::t('app', 'Data/Hora Emissão'),
            'ide_tpImp' => Yii::t('app', 'Tipo de Impressão'),
            'ide_tpEmis' => Yii::t('app', 'Tipo de Emissão'),
            'ide_cDV' => Yii::t('app', 'Cód. Verificador'),
            'ide_tpAmb' => Yii::t('app', 'Tipo de Ambiente'),
            'ide_tpCTe' => Yii::t('app', 'Tipo de CTe'),
            'ide_procEmi' => Yii::t('app', 'Ide Proc Emi'),
            'ide_verProc' => Yii::t('app', 'Ide Ver Proc'),
            'ide_refCTe' => Yii::t('app', 'CTe referenciado'),
            'ide_cMunEnv' => Yii::t('app', 'Cod. Mun.'),
            'ide_xMunEnv' => Yii::t('app', 'Municipio Env'),
            'ide_UFEnv' => Yii::t('app', 'UF Env'),
            'ide_modal' => Yii::t('app', 'Modal'),
            'ide_tpServ' => Yii::t('app', 'Tipo de serviço'),
            'ide_cMunIni' => Yii::t('app', 'Cod. Mun. Ini'),
            'ide_xMunIni' => Yii::t('app', 'Nome Mun. Ini'),
            'ide_UFIni' => Yii::t('app', 'UF Ini'),
            'ide_cMunFim' => Yii::t('app', 'Cod. Mun. Fim'),
            'ide_xMunFim' => Yii::t('app', 'Nome Mun Fim'),
            'ide_UFFim' => Yii::t('app', 'UF FIM'),
            'ide_retira' => Yii::t('app', 'Retira'),
            'ide_xDetRetira' => Yii::t('app', 'Det. Retira'),
            'ide_dhCont' => Yii::t('app', 'Data/Hora'),
            'ide_xJust' => Yii::t('app', 'Justificativa'),
            'toma' => Yii::t('app', 'Toma'),
            'tomador' => Yii::t('app', 'Tomador'),
            'emitente' => Yii::t('app', 'Emitente'),
            'remetente' => Yii::t('app', 'Remetente'),
            'destinatario' => Yii::t('app', 'Destinatário'),
            'expedidor' => Yii::t('app', 'Expedidor'),
            'recebedor' => Yii::t('app', 'Recebedor'),
            'vPrest_vTPrest' => Yii::t('app', 'Valor Total'),
            'vPrest_vRec' => Yii::t('app', 'Valor Recebido'),
            'comp_xNome' => Yii::t('app', 'Componente - nome'),
            'comp_vComp' => Yii::t('app', 'Componente - Valor'),
            'icms' => Yii::t('app', 'ICMS'),
            'infCarga' => Yii::t('app', 'Inf. Carga'),
            'infQ_cUnid' => Yii::t('app', 'Unidade'),
            'infQ_tpMed' => Yii::t('app', 'Medida'),
            'infQ_qCarga' => Yii::t('app', 'Qtde'),
            'infNFe' => Yii::t('app', 'NFe'),
            'infNF' => Yii::t('app', 'NF'),
            'seguro' => Yii::t('app', 'Seguro'),
            'infModal_versaoModal' => Yii::t('app', 'Versão Modal'),
            'rodo' => Yii::t('app', 'Rodo'),
            'veiculo' => Yii::t('app', 'Veículo'),
            'motorista' => Yii::t('app', 'Motorista'),
            'pathXML' => Yii::t('app', 'Path Xml'),
            'pathPDF' => Yii::t('app', 'Path Pdf'),
            'entrega_data' => Yii::t('app', 'Data'),
            'entrega_hora' => Yii::t('app', 'Hora'),
            'entrega_nome' => Yii::t('app', 'Nome'),
            'entrega_doc' => Yii::t('app', 'Documento'),
            'status' => Yii::t('app', 'Status'),
        ];
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
