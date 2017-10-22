<?php

namespace backend\modules\cotacao\models;

use Yii;
use backend\commands\Basicos;
use backend\models\Calculos;

/**
 * This is the model class for table "cotacao".
 *
 * @property integer $id
 * @property string $cridt
 * @property string $criusu
 * @property string $dono
 * @property integer $numero
 * @property string $tipofrete
 * @property string $entregalocal
 * @property string $pagadorenvolvido
 * @property string $pagadorcnpj
 * @property string $formapagamento
 * @property string $remetente
 * @property string $destinatario
 * @property string $consignatario
 * @property string $notasnumero
 * @property string $notasvalor
 * @property string $notaspeso
 * @property string $notasvolumes
 * @property string $notasaltura
 * @property string $notaslargura
 * @property string $notascomprimento
 * @property string $notasdimensoes
 * @property string $pesoreal
 * @property string $pesocubado
 * @property string $fretevalor
 * @property string $fretepeso
 * @property string $taxacoleta
 * @property string $taxaentrega
 * @property string $taxaseguro
 * @property string $taxagris
 * @property string $taxadespacho
 * @property string $taxaitr
 * @property string $taxaextra
 * @property string $taxaseccat
 * @property string $taxapedagio
 * @property string $taxaoutros
 * @property string $taxafretevalor
 * @property string $desconto
 * @property string $fretetotal
 * @property string $naturezacarga
 * @property string $status
 * @property integer $baixamanifesto
 * @property string $manifesto
 * @property integer $baixacoleta
 * @property string $coletadata
 * @property string $coletahora
 * @property string $coletanome
 * @property string $coletaplaca
 * @property integer $baixaentrega
 * @property string $entregadata
 * @property string $entregahora
 * @property string $entreganome
 * @property string $entregadoc
 * @property integer $baixafatura
 * @property string $fatura
 * @property integer $baixapagamento
 * @property string $pagamentorecibo
 * @property string $pagamentodata
 * @property string $tabela
 * @property string $observacoes
 */
class Cotacao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cotacao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cridt', 'criusu', 'dono', 'tipofrete', 'pagadorenvolvido',
            'formapagamento', 'remetente', 'destinatario', 'notasnumero',
            'notasvalor', 'notaspeso', 'notasvolumes', 'notasdimensoes',
            'notasaltura', 'notaslargura', 'notascomprimento', 'tabela',
            'pesoreal', 'pesocubado', 'pagadorcnpj'], 'required'],
            [['cridt', 'coletadata', 'entregadata', 'pagamentodata'], 'safe'],
            [['baixamanifesto', 'baixacoleta', 'baixaentrega', 'baixafatura', 'baixapagamento'], 'integer'],
            [['criusu', 'naturezacarga', 'status', 'coletanome', 'entreganome'], 'string', 'max' => 50],
            [['dono', 'pagadorcnpj', 'remetente', 'destinatario', 'consignatario', 'pesoreal', 'pesocubado', 'fretevalor', 'fretepeso', 'taxacoleta', 'taxaentrega', 'taxaseguro', 'taxagris', 'taxadespacho', 'taxaitr', 'taxaextra', 'taxaseccat', 'taxapedagio', 'taxaoutros', 'taxafretevalor', 'desconto', 'fretetotal'], 'string', 'max' => 15],
            [['manifesto', 'coletaplaca', 'fatura', 'tabela'], 'string', 'max' => 10],
            [['tipofrete', 'pagadorenvolvido', 'formapagamento', 'entregadoc'], 'string', 'max' => 20],
            [['entregalocal', 'notasnumero', 'notasvalor', 'notaspeso', 'notasvolumes', 'notasdimensoes'], 'string', 'max' => 100],
            [['coletahora', 'entregahora'], 'string', 'max' => 5],
            [['pagamentorecibo'], 'string', 'max' => 40],
            [['observacoes'], 'string', 'max' => 300],
            [['entregadata', 'coletadata'], 'match', 'pattern' => '/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/'],
            [['coletahora', 'entregahora'], 'match', 'pattern' => '/^([0-1][0-9]|[2][0-3]):[0-5][0-9]$/'],
        ];
    }

    public function beforeSave($insert) {
        $basicos = new Basicos();

        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {
                // Número da minuta
                $ultima = self::find()
                        ->select(['numero'])
                        ->where([
                            'dono' => \Yii::$app->user->identity['cnpj']
                        ])
                        ->orderBy('numero DESC')
                        ->one();

                $this->numero = ($ultima === null) ? 1 : $ultima->numero + 1;
            }

            // Baixa Coleta / Entrega
            $baixacoleta = ($this->coletadata == '') ? 0 : 1;
            $baixaentrega = ($this->entregadata == '') ? 0 : 1;

            $this->baixacoleta = $baixacoleta;
            $this->baixaentrega = $baixaentrega;

            // Status da Emissão
            if ($baixacoleta == 0) {
                $status = 'EMITIDA';
            } else {

                $status = 'COLETADA';

                if ($baixaentrega == 1) {
                    $status = 'ENTREGUE';
                }
            }
            $this->status = $status;

            // Transforma as datas de entrega e coleta
            $this->entregadata = ($this->entregadata == '') ? null : $basicos->formataData('db', ($this->entregadata));
            $this->coletadata = ($this->coletadata == '') ? null : $basicos->formataData('db', ($this->coletadata));

            // Cálculo do FRETE
            $arrayCalculo = [
                'tabela' => $this->tabela,
                'pesoreal' => $this->pesoreal,
                'pesocubado' => $this->pesocubado,
                'taxaextra' => $this->taxaextra,
                'desconto' => $this->desconto,
                'notasvalor' => $this->notasvalor,
                'notasvolumes' => $this->notasvolumes
            ];

            // Modelo de calculo
            $calculos = new Calculos();
            $calculaFrete = $calculos->calculaFrete('db', $arrayCalculo);

            /*
              $this->taxacoleta = '';
              $this->taxaentrega = '';
              $this->taxaseguro = '';
              $this->baixamanifesto = 0;
              $this->manifesto = '';
              $this->baixafatura = 0;
              $this->fatura = '';
              $this->baixapagamento = 0;
              $this->pagamentorecibo = '';
              $this->pagamentodata = null;
             */

            // Se não deu erro nos calculos, define as variáveis da minuta!
            $this->fretevalor = (isset($calculaFrete['valorminimo'])) ? $calculaFrete['valorminimo'] : '0.00';
            $this->fretepeso = (isset($calculaFrete['valorexcedente'])) ? $calculaFrete['valorexcedente'] : '0.00';
            $this->taxafretevalor = (isset($calculaFrete['tabela_fretevalor'])) ? $calculaFrete['tabela_fretevalor'] : '0.00';
            $this->taxadespacho = (isset($calculaFrete['tabela_despacho'])) ? $calculaFrete['tabela_despacho'] : '0.00';
            $this->taxaseccat = (isset($calculaFrete['tabela_seccat'])) ? $calculaFrete['tabela_seccat'] : '0.00';
            $this->taxaitr = (isset($calculaFrete['tabela_itr'])) ? $calculaFrete['tabela_itr'] : '0.00';
            $this->taxagris = (isset($calculaFrete['tabela_gris'])) ? $calculaFrete['tabela_gris'] : '0.00';
            $this->taxapedagio = (isset($calculaFrete['tabela_pedagio'])) ? $calculaFrete['tabela_pedagio'] : '0.00';
            $this->taxaoutros = (isset($calculaFrete['tabela_outros'])) ? $calculaFrete['tabela_outros'] : '0.00';
            $this->fretetotal = (isset($calculaFrete['fretetotal'])) ? $calculaFrete['fretetotal'] : '0.00';


            // Dimensões da carga
            // As dimensões estão no formato string => |alt x larg x comp|alt x larg x comp
            //$altura = array();
            //$largura = array();
            //$comprimento = array();
            //$dimensoes = explode('|',$this->notasdimensoes);
            //foreach ( $dimensoes as $dimensao ){
            //	if($dimensao != ''){
            //		$divisao = explode('x', $dimensao);
            //		$altura[] = $divisao[0];
            //		$largura[] = $divisao[1];
            //		$comprimento[] = $divisao[2];
            //
            //	}
            //}
            //$this->notasaltura = '|' . implode('|', $altura);
            //$this->notaslargura = '|' . implode('|', $largura);
            //$this->notascomprimento = '|' . implode('|', $comprimento);

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
            'cridt' => Yii::t('app', 'Cridt'),
            'criusu' => Yii::t('app', 'Criusu'),
            'dono' => Yii::t('app', 'Dono'),
            'numero' => Yii::t('app', 'Numero'),
            'tipofrete' => Yii::t('app', 'Tipofrete'),
            'entregalocal' => Yii::t('app', 'Entregalocal'),
            'pagadorenvolvido' => Yii::t('app', 'Pagadorenvolvido'),
            'pagadorcnpj' => Yii::t('app', 'Pagadorcnpj'),
            'formapagamento' => Yii::t('app', 'Formapagamento'),
            'remetente' => Yii::t('app', 'Remetente'),
            'destinatario' => Yii::t('app', 'Destinatario'),
            'consignatario' => Yii::t('app', 'Consignatario'),
            'notasnumero' => Yii::t('app', 'Notasnumero'),
            'notasvalor' => Yii::t('app', 'Notasvalor'),
            'notaspeso' => Yii::t('app', 'Notaspeso'),
            'notasvolumes' => Yii::t('app', 'Notasvolumes'),
            'notasaltura' => Yii::t('app', 'Notasaltura'),
            'notaslargura' => Yii::t('app', 'Notaslargura'),
            'notascomprimento' => Yii::t('app', 'Notascomprimento'),
            'notasdimensoes' => Yii::t('app', 'Notasdimensoes'),
            'pesoreal' => Yii::t('app', 'Pesoreal'),
            'pesocubado' => Yii::t('app', 'Pesocubado'),
            'fretevalor' => Yii::t('app', 'Fretevalor'),
            'fretepeso' => Yii::t('app', 'Fretepeso'),
            'taxacoleta' => Yii::t('app', 'Taxacoleta'),
            'taxaentrega' => Yii::t('app', 'Taxaentrega'),
            'taxaseguro' => Yii::t('app', 'Taxaseguro'),
            'taxagris' => Yii::t('app', 'Taxagris'),
            'taxadespacho' => Yii::t('app', 'Taxadespacho'),
            'taxaitr' => Yii::t('app', 'Taxaitr'),
            'taxaextra' => Yii::t('app', 'Taxaextra'),
            'taxaseccat' => Yii::t('app', 'Taxaseccat'),
            'taxapedagio' => Yii::t('app', 'Taxapedagio'),
            'taxaoutros' => Yii::t('app', 'Taxaoutros'),
            'taxafretevalor' => Yii::t('app', 'Taxafretevalor'),
            'desconto' => Yii::t('app', 'Desconto'),
            'fretetotal' => Yii::t('app', 'Fretetotal'),
            'naturezacarga' => Yii::t('app', 'Naturezacarga'),
            'status' => Yii::t('app', 'Status'),
            'baixamanifesto' => Yii::t('app', 'Baixamanifesto'),
            'manifesto' => Yii::t('app', 'Manifesto'),
            'baixacoleta' => Yii::t('app', 'Baixacoleta'),
            'coletadata' => Yii::t('app', 'Coletadata'),
            'coletahora' => Yii::t('app', 'Coletahora'),
            'coletanome' => Yii::t('app', 'Coletanome'),
            'coletaplaca' => Yii::t('app', 'Coletaplaca'),
            'baixaentrega' => Yii::t('app', 'Baixaentrega'),
            'entregadata' => Yii::t('app', 'Entregadata'),
            'entregahora' => Yii::t('app', 'Entregahora'),
            'entreganome' => Yii::t('app', 'Entreganome'),
            'entregadoc' => Yii::t('app', 'Entregadoc'),
            'baixafatura' => Yii::t('app', 'Baixafatura'),
            'fatura' => Yii::t('app', 'Fatura'),
            'baixapagamento' => Yii::t('app', 'Baixapagamento'),
            'pagamentorecibo' => Yii::t('app', 'Pagamentorecibo'),
            'pagamentodata' => Yii::t('app', 'Pagamentodata'),
            'tabela' => Yii::t('app', 'Tabela'),
            'observacoes' => Yii::t('app', 'Observacoes'),
        ];
    }

    public function stringDataGrid($tipo = 'cliente', $parametros) {
        if ($parametros['cnpj'] == '') {
            return '---';
        }

        $model = new \backend\modules\clientes\models\Clientes();
        $cliente = $model->find()
                ->select(['nome'])
                ->where(['cnpj' => $parametros['cnpj']])
                ->one();

        if ($cliente !== null) {
            return $cliente->nome;
        } else {
            return 'Erro na consulta';
        }
    }

    /**
     * @inheritdoc
     * @return CotacaoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CotacaoQuery(get_called_class());
    }
}
