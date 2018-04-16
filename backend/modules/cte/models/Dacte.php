<?php

namespace backend\modules\cte\models;

use NFePHP\DA\CTe\DacteV3;
use backend\modules\cte\models\Cte;
use Exception;
use NFePHP\DA\Legacy\Dom;
use NFePHP\DA\Legacy\Pdf;
use NFePHP\DA\Legacy\Common;

class Dacte extends DacteV3
{

    const NFEPHP_SITUACAO_EXTERNA_CANCELADA = 1;
    const NFEPHP_SITUACAO_EXTERNA_DENEGADA = 2;
    const SIT_DPEC = 3;

    protected $logoAlign = 'C';
    protected $yDados = 0;
    protected $situacao_externa = 0;
    protected $numero_registro_dpec = '';
    protected $pdf;
    protected $xml;
    protected $logomarca = '';
    protected $errMsg = '';
    protected $errStatus = false;
    protected $orientacao = 'P';
    protected $papel = 'A4';
    protected $destino = 'I';
    protected $pdfDir = '';
    protected $fontePadrao = 'Times';
    protected $version = '1.3.0';
    protected $wPrint;
    protected $hPrint;
    protected $dom;
    protected $infCte;
    protected $infCteComp;
    protected $chaveCTeRef;
    protected $tpCTe;
    protected $ide;
    protected $emit;
    protected $enderEmit;
    protected $rem;
    protected $enderReme;
    protected $dest;
    protected $enderDest;
    protected $exped;
    protected $enderExped;
    protected $receb;
    protected $enderReceb;
    protected $infCarga;
    protected $infQ;
    protected $seg;
    protected $modal;
    protected $rodo;
    protected $moto;
    protected $veic;
    protected $ferrov;
    protected $Comp;
    protected $infNF;
    protected $infNFe;
    protected $compl;
    protected $ICMS;
    protected $imp;
    protected $toma4;
    protected $toma03;
    protected $tpEmis;
    protected $tpImp;
    protected $tpAmb;
    protected $vPrest;
    protected $wAdic = 150;
    protected $textoAdic = '';
    protected $debugMode = 2;
    protected $formatPadrao;
    protected $formatNegrito;
    protected $aquav;
    protected $preVisualizar;
    protected $flagDocOrigContinuacao;
    protected $arrayNFe = array();
    protected $siteDesenvolvedor;
    protected $nomeDesenvolvedor;
    protected $totPag;
    protected $idDocAntEle = [];
    protected $idCTe = '';
    protected $entNome = '';
    protected $entRG = '';
    protected $entData = '';
    protected $entHora = '';

    /**
     * __construct
     *
     * @param string $docXML Arquivo XML da CTe
     * @param string $sOrientacao (Opcional) Orientação da impressão P ou L
     * @param string $sPapel Tamanho do papel (Ex. A4)
     * @param string $sPathLogo Caminho para o arquivo do logo
     * @param string $sDestino Estabelece a direção do envio do documento PDF
     * @param string $sDirPDF Caminho para o diretorio de armaz. dos PDF
     * @param string $fonteDACTE Nome da fonte a ser utilizada
     * @param number $mododebug 0-Não 1-Sim e 2-nada (2 default)
     * @param string $preVisualizar 0-Não 1-Sim
     */
    public function __construct(
        $docXML = '',
        $sOrientacao = '',
        $sPapel = '',
        $sPathLogo = '',
        $idCTe = '',
        $sDestino = 'I',
        $sDirPDF = '',
        $fonteDACTE = '',
        $mododebug = 2,
        $preVisualizar = false,
        $nomeDesenvolvedor = 'Powered by NFePHP (GNU/GPLv3 GNU/LGPLv3) © www.nfephp.org',
        $siteDesenvolvedor = 'https://www.geradorfiscal.com.br/'
    ) {

        if (is_numeric($mododebug)) {
            $this->debugMode = $mododebug;
        }
        if ($mododebug == 1) {
            //ativar modo debug
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } elseif ($mododebug == 0) {
            //desativar modo debug
            error_reporting(0);
            ini_set('display_errors', 'Off');
        }
        $this->orientacao = $sOrientacao;
        $this->papel = $sPapel;
        $this->pdf = '';
        $this->xml = $docXML;
        $this->logomarca = $sPathLogo;
        $this->idCTe = $idCTe;
        $this->destino = $sDestino;
        $this->pdfDir = $sDirPDF;
        $this->preVisualizar = $preVisualizar;
        $this->siteDesenvolvedor = $siteDesenvolvedor;
        $this->nomeDesenvolvedor = $nomeDesenvolvedor;

        $model = $this->findModel($this->idCTe);

        $this->entNome = $model->ent_nome;
        $this->entData = $model->ent_data;
        $this->entRG = $model->ent_rg;
        $this->entHora = $model->ent_hora;

        // verifica se foi passa a fonte a ser usada
        if (!empty($fonteDACTE)) {
            $this->fontePadrao = $fonteDACTE;
        }
        $this->formatPadrao = array(
            'font' => $this->fontePadrao,
            'size' => 6,
            'style' => '');
        $this->formatNegrito = array(
            'font' => $this->fontePadrao,
            'size' => 7,
            'style' => 'B');
        //se for passado o xml
        if (!empty($this->xml)) {
            $this->dom = new Dom();
            $this->dom->loadXML($this->xml);
            $this->cteProc = $this->dom->getElementsByTagName("cteProc")->item(0);
            $this->infCte = $this->dom->getElementsByTagName("infCte")->item(0);
            $this->ide = $this->dom->getElementsByTagName("ide")->item(0);
            $this->emit = $this->dom->getElementsByTagName("emit")->item(0);
            $this->enderEmit = $this->dom->getElementsByTagName("enderEmit")->item(0);
            $this->rem = $this->dom->getElementsByTagName("rem")->item(0);
            $this->enderReme = $this->dom->getElementsByTagName("enderReme")->item(0);
            $this->dest = $this->dom->getElementsByTagName("dest")->item(0);
            $this->enderDest = $this->dom->getElementsByTagName("enderDest")->item(0);
            $this->exped = $this->dom->getElementsByTagName("exped")->item(0);
            $this->enderExped = $this->dom->getElementsByTagName("enderExped")->item(0);
            $this->receb = $this->dom->getElementsByTagName("receb")->item(0);
            $this->enderReceb = $this->dom->getElementsByTagName("enderReceb")->item(0);
            $this->infCarga = $this->dom->getElementsByTagName("infCarga")->item(0);
            $this->infQ = $this->dom->getElementsByTagName("infQ");
            $this->seg = $this->dom->getElementsByTagName("seg")->item(0);
            $this->rodo = $this->dom->getElementsByTagName("rodo")->item(0);
            $this->lota = $this->pSimpleGetValue($this->rodo, "lota");
            $this->moto = $this->dom->getElementsByTagName("moto")->item(0);
            $this->veic = $this->dom->getElementsByTagName("veic");
            $this->ferrov = $this->dom->getElementsByTagName("ferrov")->item(0);
            // adicionar outros modais
            $this->infCteComp = $this->dom->getElementsByTagName("infCteComp")->item(0);
            $this->chaveCTeRef = $this->pSimpleGetValue($this->infCteComp, "chave");
            $this->vPrest = $this->dom->getElementsByTagName("vPrest")->item(0);
            $this->Comp = $this->dom->getElementsByTagName("Comp");
            $this->infNF = $this->dom->getElementsByTagName("infNF");
            $this->infNFe = $this->dom->getElementsByTagName("infNFe");
            $this->infOutros = $this->dom->getElementsByTagName("infOutros");
            $this->compl = $this->dom->getElementsByTagName("compl");
            $this->ICMS = $this->dom->getElementsByTagName("ICMS")->item(0);
            $this->ICMSSN = $this->dom->getElementsByTagName("ICMSSN")->item(0);
            $this->imp = $this->dom->getElementsByTagName("imp")->item(0);

            $vTrib = $this->pSimpleGetValue($this->imp, "vTotTrib");
            if (!is_numeric($vTrib)) {
                $vTrib = 0;
            }
            $textoAdic = number_format($vTrib, 2, ",", ".");

            $this->textoAdic = "o valor aproximado de tributos incidentes sobre o preço deste serviço é de R$"
                    .$textoAdic;
            $this->toma4 = $this->dom->getElementsByTagName("toma4")->item(0);
            $this->toma03 = $this->dom->getElementsByTagName("toma3")->item(0);
            //modal aquaviário
            $this->aquav = $this->dom->getElementsByTagName("aquav")->item(0);
            $tomador = $this->pSimpleGetValue($this->toma03, "toma");
            //0-Remetente;1-Expedidor;2-Recebedor;3-Destinatário;4-Outros
            switch ($tomador) {
                case '0':
                    $this->toma = $this->rem;
                    $this->enderToma = $this->enderReme;
                    break;
                case '1':
                    $this->toma = $this->exped;
                    $this->enderToma = $this->enderExped;
                    break;
                case '2':
                    $this->toma = $this->receb;
                    $this->enderToma = $this->enderReceb;
                    break;
                case '3':
                    $this->toma = $this->dest;
                    $this->enderToma = $this->enderDest;
                    break;
                default:
                    $this->toma = $this->toma4;
                    $this->enderToma = $this->pSimpleGetValue($this->toma4, "enderToma");
                    break;
            }
            /*$seguro = $this->pSimpleGetValue($this->seg, "respSeg");
            switch ($seguro) {
                case '0':
                    $this->respSeg = 'Remetente';
                    break;
                case '1':
                    $this->respSeg = 'Expedidor';
                    break;
                case '2':
                    $this->respSeg = 'Recebedor';
                    break;
                case '3':
                    $this->respSeg = 'Destinatário';
                    break;
                case '4':
                    $this->respSeg = 'Emitente';
                    break;
                case '5':
                    $this->respSeg = 'Tomador';
                    break;
                default:
                    $this->respSeg = '';
                    break;
            }*/
            $this->tpEmis = $this->pSimpleGetValue($this->ide, "tpEmis");
            $this->tpImp = $this->pSimpleGetValue($this->ide, "tpImp");
            $this->tpAmb = $this->pSimpleGetValue($this->ide, "tpAmb");
            $this->tpCTe = $this->pSimpleGetValue($this->ide, "tpCTe");
            $this->protCTe = $this->dom->getElementsByTagName("protCTe")->item(0);
            //01-Rodoviário; //02-Aéreo; //03-Aquaviário; //04-Ferroviário;//05-Dutoviário
            $this->modal = $this->pSimpleGetValue($this->ide, "modal");
        }
    }

    /**
     * zDescricaoCarga
     * Monta o campo com os dados do remetente na DACTE. ( retrato  e paisagem  )
     *
     * @param  number $x Posição horizontal canto esquerdo
     * @param  number $y Posição vertical canto superior
     * @return number Posição vertical final
     */
    protected function zDescricaoCarga($x = 0, $y = 0)
    {
        $oldX = $x;
        $oldY = $y;
        if ($this->orientacao == 'P') {
            $maxW = $this->wPrint;
        } else {
            $maxW = $this->wPrint - $this->wCanhoto;
        }
        $w = $maxW;
        $h = 17;
        $texto = 'PRODUTO PREDOMINANTE';
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 6,
            'style' => '');
        $this->pTextBox($x, $y, $w, $h, $texto, $aFont, 'T', 'L', 1, '');
        $texto = $this->pSimpleGetValue($this->infCarga, "proPred");
        $aFont = $this->formatNegrito;
        $this->pTextBox($x, $y + 2.8, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $x = $w * 0.56;
        $this->pdf->Line($x, $y, $x, $y + 8);
        $aFont = $this->formatPadrao;
        $texto = 'OUTRAS CARACTERÍSTICAS DA CARGA';
        $this->pTextBox($x + 1, $y, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $texto = $this->pSimpleGetValue($this->infCarga, "xOutCat");
        $aFont = $this->formatNegrito;
        $this->pTextBox($x + 1, $y + 3, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $x = $w * 0.8;
        $this->pdf->Line($x, $y, $x, $y + 8);
        $aFont = $this->formatPadrao;
        $texto = 'VALOR TOTAL DA CARGA';
        $this->pTextBox($x + 1, $y, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $texto = $this->pSimpleGetValue($this->infCarga, "vCarga") == "" ?
            $this->pSimpleGetValue($this->infCarga, "vMerc") : $this->pSimpleGetValue($this->infCarga, "vCarga");
        $texto = number_format($texto, 2, ",", ".");
        $aFont = $this->formatNegrito;
        $this->pTextBox($x + 1, $y + 3, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $y += 8;
        $x = $oldX;
        $this->pdf->Line($x, $y, $w + 1, $y);
        $texto = 'PESO BRUTO (KG)';
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 5,
            'style' => '');
        $this->pTextBox($x+8, $y, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        //$texto = $this->pSimpleGetValue($this->infQ->item(0), "qCarga") . "\r\n";
        $texto = number_format(
            $this->pSimpleGetValue(
                $this->infQ->item(0),
                "qCarga"
            ),
            3,
            ",",
            "."
        );
        //$texto .= ' ' . $this->zUnidade($this->pSimpleGetValue($this->infQ->item(0), "cUnid"));
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 7,
            'style' => 'B');
        $this->pTextBox($x+2, $y + 3, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $x = $w * 0.12;
        $this->pdf->Line($x+13.5, $y, $x+13.5, $y + 9);
        $texto = 'PESO BASE CÁLCULO (KG)';
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 5,
            'style' => '');
        $this->pTextBox($x+20, $y, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $pesoreal = $this->pSimpleGetValue(
                $this->infQ->item(0),
                "qCarga"
            );
        $pesocubado = $this->pSimpleGetValue(
                $this->infQ->item(1),
                "qCarga"
            );
        $pesomaior = ($pesoreal > $pesocubado) ? $pesoreal : $pesocubado;
        $texto = number_format(
            $pesomaior,
            3,
            ",",
            "."
        );
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 7,
            'style' => 'B');
        $this->pTextBox($x+17, $y + 3, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $x = $w * 0.24;
        $this->pdf->Line($x+25, $y, $x+25, $y + 9);
        $texto = 'PESO AFERIDO (KG)';
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 5,
            'style' => '');
        $this->pTextBox($x+35, $y, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $texto = number_format(
            $this->pSimpleGetValue(
                $this->infQ->item(0),
                "qCarga"
            ),
            3,
            ",",
            "."
        );
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 7,
            'style' => 'B');
        $this->pTextBox($x+28, $y + 3, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $x = $w * 0.36;
        $this->pdf->Line($x+41.3, $y, $x+41.3, $y + 9);
        $texto = 'PESO CUBADO (KG)';
        $aFont = $this->formatPadrao;
        $this->pTextBox($x+60, $y, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $qCarga = '';
        if ($this->pSimpleGetValue($this->infQ->item(0), "cUnid") == '00') {
            $qCarga = $this->pSimpleGetValue($this->infQ->item(0), "qCarga");
        } elseif ($this->pSimpleGetValue($this->infQ->item(1), "cUnid") == '01') {
            $qCarga = $this->pSimpleGetValue($this->infQ->item(1), "qCarga");
        } elseif ($this->pSimpleGetValue($this->infQ->item(2), "cUnid") == '00') {
            $qCarga = $this->pSimpleGetValue($this->infQ->item(2), "qCarga");
        }
        $texto = !empty($qCarga) ? number_format($qCarga, 3, ",", ".") : '';
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 7,
            'style' => 'B');
        $this->pTextBox($x+50, $y + 3, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $x = $w * 0.45;
        //$this->pdf->Line($x+37, $y, $x+37, $y + 9);
        $texto = 'QTDE(VOL)';
        $aFont = $this->formatPadrao;
        $this->pTextBox($x+85, $y, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $qCarga = '';
        if ($this->pSimpleGetValue($this->infQ->item(2), "cUnid") == 03) {
            $qCarga = $this->pSimpleGetValue($this->infQ->item(2), "qCarga");
        } elseif ($this->pSimpleGetValue($this->infQ->item(1), "cUnid") == 03) {
            $qCarga = $this->pSimpleGetValue($this->infQ->item(1), "qCarga");
        }
        $texto = !empty($qCarga) ? number_format($qCarga, 3, ",", ".") : '';
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 7,
            'style' => 'B');
        $this->pTextBox($x+85, $y + 3, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $x = $w * 0.53;
        $this->pdf->Line($x+56, $y, $x+56, $y + 9);
        /*$texto = 'NOME DA SEGURADORA';
        $aFont = $this->formatPadrao;
        $this->pTextBox($x, $y, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $texto = $this->pSimpleGetValue($this->seg, "xSeg");
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 7,
            'style' => 'B');
        $this->pTextBox($x + 31, $y, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $y += 3;
        $this->pdf->Line($x, $y, $w + 1, $y);
        $texto = 'RESPONSÁVEL';
        $aFont = $this->formatPadrao;
        $this->pTextBox($x, $y, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $texto = $this->respSeg;
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 7,
            'style' => 'B');
        $this->pTextBox($x, $y + 3, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $x = $w * 0.68;
        $this->pdf->Line($x, $y, $x, $y + 6);
        $texto = 'NÚMERO DA APOLICE';
        $aFont = $this->formatPadrao;
        $this->pTextBox($x, $y, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $texto = $this->pSimpleGetValue($this->seg, "nApol");
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 7,
            'style' => 'B');
        $this->pTextBox($x, $y + 3, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $x = $w * 0.85;
        $this->pdf->Line($x, $y, $x, $y + 6);
        $texto = 'NÚMERO DA AVERBAÇÃO';
        $aFont = $this->formatPadrao;
        $this->pTextBox($x, $y, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        $texto = $this->pSimpleGetValue($this->seg, "nAver");
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 7,
            'style' => 'B');
        $this->pTextBox($x, $y + 3, $w, $h, $texto, $aFont, 'T', 'L', 0, '');*/
    } //fim da função zDescricaoCarga

    /**
     * zCanhoto
     * Monta o campo com os dados do remetente na DACTE.
     *
     * @param  number $x Posição horizontal canto esquerdo
     * @param  number $y Posição vertical canto superior
     * @return number Posição vertical final
     */
    protected function zCanhoto($x = 0, $y = 0)
    {
        $this->zhDashedLine($x, $y+2, $this->wPrint, 0.1, 80);
        $y = $y + 2;
        $oldX = $x;
        $oldY = $y;
        if ($this->orientacao == 'P') {
            $maxW = $this->wPrint;
        } else {
            $maxW = $this->wPrint - $this->wCanhoto;
        }
        $w = $maxW - 1;
        $h = 20;
        $y = $y + 1;
        $texto = 'DECLARO QUE RECEBI OS VOLUMES DESTE CONHECIMENTO EM PERFEITO ESTADO ';
        $texto .= 'PELO QUE DOU POR CUMPRIDO O PRESENTE CONTRATO DE TRANSPORTE';
        $aFont = $this->formatPadrao;
        $this->pTextBox($x, $y, $w, $h, $texto, $aFont, 'T', 'C', 1, '');
        $y += 3.4;
        $this->pdf->Line($x, $y, $w + 1, $y); // LINHA ABAICO DO TEXTO DECLARO QUE RECEBI...

        $texto = 'NOME';
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 6,
            'style' => '');
        $this->pTextBox($x, $y, $w * 0.25, $h, $texto, $aFont, 'T', 'L', 0, '');
        // $x += $w * 0.25;

        $y += 3.4;

        $texto = $this->entNome;
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 7,
            'style' => 'B');
        $this->pTextBox($x, $y, $w * 0.25, $h, $texto, $aFont, 'T', 'L', 0, '');
        $x += $w * 0.25;
        $y -= 3.4;

        $this->pdf->Line($x, $y, $x, $y + 16.5);

        $texto = 'ASSINATURA / CARIMBO';
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 6,
            'style' => '');
        $this->pTextBox($x, $y, $w * 0.25, $h - 3.4, $texto, $aFont, 'B', 'C', 0, '');
        $x += $w * 0.25;

        $this->pdf->Line($x, $y, $x, $y + 16.5);

        $texto = 'TÉRMINO DA PRESTAÇÃO - DATA/HORA';
        
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 6,
            'style' => '');
        $this->pTextBox($x + 10, $y, $w * 0.25, $h - 3.4, $texto, $aFont, 'T', 'C', 0, '');

        $y += 3.4;
        $x += 10;

        $texto = $this->entData . ' - ' . $this->entHora;
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 10,
            'style' => 'B');
        $this->pTextBox($x, $y, $w * 0.25, $h, $texto, $aFont, 'T', 'C', 0, '');

        $y -= 3.4;
        $x -= 10;

        $x = $oldX;
        $y = $y + 5;

        $this->pdf->Line($x, $y+3, $w * 0.255, $y+3); // LINHA HORIZONTAL ACIMA DO RG ABAIXO DO NOME

        $texto = 'RG';
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 6,
            'style' => '');
        $this->pTextBox($x, $y+3, $w * 0.33, $h, $texto, $aFont, 'T', 'L', 0, '');
        $y += 6.4;

        $texto = $this->entRG;
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 8,
            'style' => 'B');
        $this->pTextBox($x, $y, $w * 0.25, $h, $texto, $aFont, 'T', 'L', 0, '');
//        $x += $w * 0.25;
        $y -= 6.4;

        $x += $w * 0.85;

        $this->pdf->Line($x, $y + 11.5, $x, $y - 5); // LINHA VERTICAL PROXIMO AO CT-E

        $x -= 10;

        $texto = "CT-E";
        $aFont = $this->formatNegrito;
        $this->pTextBox($x+10, $y - 5, $w * 0.15, $h, $texto, $aFont, 'T', 'C', 0, '');
        $texto = "\r\n Nº. DOCUMENTO  " . $this->pSimpleGetValue($this->ide, "nCT") . " \n";
        $texto .= "\r\n SÉRIE  " . $this->pSimpleGetValue($this->ide, "serie");
        $aFont = array(
            'font' => $this->fontePadrao,
            'size' => 6,
            'style' => '');
        $this->pTextBox($x+10, $y - 8, $w * 0.15, $h, $texto, $aFont, 'C', 'C', 0, '');
        $x = $oldX;
        //$this->zhDashedLine($x, $y + 7.5, $this->wPrint, 0.1, 80);
    } //fim da função canhotoDACTE

    /**
     * Finds the Cte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cte::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}