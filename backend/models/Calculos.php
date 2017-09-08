<?php

namespace backend\models;

use Yii;
use backend\commands\Basicos;
use backend\models\Tabelas;

class Calculos extends \yii\db\ActiveRecord
{
    public $msg     = array();
    public $calculo = array();

    /**
     * Retorna Json com os dados do calculo
     * Verificar na formulário da minuta a duplicidade da id de notas (valor principalmente)
     * @param string $tipo
     * @param unknown $dados
     * @return Ambigous <multitype:, string>|Ambigous <multitype:, string, unknown>
     */
    public function calculaFrete($tipo = 'db', $dados = array())
    {
        // Verifica se há dados no array
        if (empty($dados)) {
            $this->msg[] = 'Dados não informados';
            return $this->msg;
        }

        if ($tipo == 'ajax') {

            $novo = [];

            $divide = explode('&', $dados);
            foreach ($divide as $separa) {
                $campos     = explode('=', $separa);
                $key        = str_replace('Minutas', '', $campos[0]);
                $key        = str_replace('%5B', '', $key);
                $key        = str_replace('%5D', '', $key);
                $novo[$key] = $campos[1];
            }

            $p = $novo;
        } else {

            // Array com os dados: seja modelo ou formulário!
            $p = (!isset($dados['Minutas'])) ? $dados : $dados['Minutas'];
        }

        // Retorna erro se nenhuma tabela foi informada.
        if ($p['tabela'] == '') {
            $this->msg[] = 'Tabela não informada';
            return $this->msg;
        }

        // Seleciona os dados da tabela
        $dadosTabela = Tabelas::findOne($p['tabela']);
        if ($dadosTabela === null) {
            $this->msg[] = 'Tabela não encontrada';
            return $this->msg;
        }

        //return $dadosTabela['nome'];
        // Peso a ser considerado para o calculo
        $peso = ($p['pesoreal'] > $p['pesocubado']) ? $p['pesoreal'] : $p['pesocubado'];

        if ($peso <= 0) {
            $this->msg[] = 'Peso não definido';
            return $this->msg;
        }

        // Peso Excedente
        $pesoexcedente = ($peso < $dadosTabela['pesominimo']) ? 0 : $peso - $dadosTabela['pesominimo'];

        // Valor mínimo do Frete definido na TABELA
        $valorminimo = $dadosTabela['valorminimo'];

        // Valor Excedente
        $valorexcedente = round($pesoexcedente * $dadosTabela['excedente'], 2);

        // Taxa extra da MINITA (na tabela também tem)
        $taxaextra = $p['taxaextra'];

        // Desconto dado na hora da emissão da MINUTA
        $desconto = $p['desconto'];

        // Valores das notas fiscais
        $notasvalor = explode('|', $p['notasvalor']);
        $valornotas = array_sum($notasvalor);

        // Valores das notas fiscais
        $notasvolumes = explode('|', $p['notasvolumes']);
        $totalvolumes = array_sum($notasvolumes);

        // Calculos da Tabela
        $tabela_fretevalor = round($dadosTabela['fretevalor'] * $valornotas / 100,
            2);
        $tabela_despacho   = $dadosTabela['despacho'];
        $tabela_seccat     = $dadosTabela['seccat'];
        $tabela_itr        = $dadosTabela['itr'];
        $tabela_gris       = round($dadosTabela['gris'] * $valornotas / 100, 2);
        $tabela_pedagio    = $dadosTabela['pedagio'];
        $tabela_outros     = $dadosTabela['outros'];

        // Calculo Frete Total
        $fretetotal = $valorminimo + $valorexcedente + $taxaextra - $desconto +
            $tabela_fretevalor + $tabela_despacho + $tabela_seccat + $tabela_itr
            +
            $tabela_gris + $tabela_pedagio + $tabela_outros;

        // Insere as variáveis uteis no array de retorno
        $this->calculo['peso']              = ($peso == '') ? '0.00' : number_format($peso,
                2, '.', '');
        $this->calculo['pesoexcedente']     = ($pesoexcedente == '') ? '0.00' : number_format($pesoexcedente,
                2, '.', '');
        $this->calculo['valorminimo']       = ($valorminimo == '') ? '0.00' : number_format($valorminimo,
                2, '.', '');
        $this->calculo['valorexcedente']    = ($valorexcedente == '') ? '0.00' : number_format($valorexcedente,
                2, '.', '');
        $this->calculo['taxaextra']         = ($taxaextra == '') ? '0.00' : number_format($taxaextra,
                2, '.', '');
        $this->calculo['desconto']          = ($desconto == '') ? '0.00' : number_format($desconto,
                2, '.', '');
        $this->calculo['valornotas']        = ($valornotas == '') ? '0.00' : number_format($valornotas,
                2, '.', '');
        $this->calculo['totalvolumes']      = $totalvolumes;
        $this->calculo['tabela_fretevalor'] = ($tabela_fretevalor == '') ? '0.00'
                : number_format($tabela_fretevalor, 2, '.', '');
        $this->calculo['tabela_despacho']   = ($tabela_despacho == '') ? '0.00' : number_format($tabela_despacho,
                2, '.', '');
        $this->calculo['tabela_seccat']     = ($tabela_seccat == '') ? '0.00' : number_format($tabela_seccat,
                2, '.', '');
        $this->calculo['tabela_itr']        = ($tabela_itr == '') ? '0.00' : number_format($tabela_itr,
                2, '.', '');
        $this->calculo['tabela_gris']       = ($tabela_gris == '') ? '0.00' : number_format($tabela_gris,
                2, '.', '');
        $this->calculo['tabela_pedagio']    = ($tabela_pedagio == '') ? '0.00' : number_format($tabela_pedagio,
                2, '.', '');
        $this->calculo['tabela_outros']     = ($tabela_outros == '') ? '0.00' : number_format($tabela_outros,
                2, '.', '');
        $this->calculo['fretetotal']        = ($fretetotal == '') ? '0.00' : number_format($fretetotal,
                2, '.', '');

        //Yii::$app->response->format = 'json';
        return $this->calculo;
        //return $dadosTabela;
    }

    /**
     * Retorna Json com os dados do calculo do CT-e
     * @param string $tipo
     * @param unknown $dados
     * @return Ambigous <multitype:, string>|Ambigous <multitype:, string, unknown>
     */
    public function calculaFretecte($tipo = 'db', $dados = array())
    {
        // Verifica se há dados no array
        if (empty($dados)) {
            $this->msg[] = 'Dados não informados';
            return $this->msg;
        }

        if ($tipo == 'ajax') {

            $novo = [];

            $divide = explode('&', $dados);
            foreach ($divide as $separa) {
                $campos     = explode('=', $separa);
                $key        = str_replace('Cte', '', $campos[0]);
                $key        = str_replace('%5B', '', $key);
                $key        = str_replace('%5D', '', $key);
                $novo[$key] = $campos[1];
            }

            $p = $novo;
            return $p;
        } else {

            // Array com os dados: seja modelo ou formulário!
            $p = (!isset($dados['Cte'])) ? $dados : $dados['Cte'];
        }

        // Retorna erro se nenhuma tabela foi informada.
        if ($p['tabela_id'] == '') {
            $this->msg[] = 'Tabela não informada';
            return $this->msg;
        }

        // Seleciona os dados da tabela
        $dadosTabela = Tabelas::findOne($p['tabela']);
        if ($dadosTabela === null) {
            $this->msg[] = 'Tabela não encontrada';
            return $this->msg;
        }

        //return $dadosTabela['nome'];
        // Peso a ser considerado para o calculo
        $peso = ($p['pesoreal'] > $p['pesocubado']) ? $p['pesoreal'] : $p['pesocubado'];

        if ($peso <= 0) {
            $this->msg[] = 'Peso não definido';
            return $this->msg;
        }

        // Peso Excedente
        $pesoexcedente = ($peso < $dadosTabela['pesominimo']) ? 0 : $peso - $dadosTabela['pesominimo'];

        // Valor mínimo do Frete definido na TABELA
        $valorminimo = $dadosTabela['valorminimo'];

        // Valor Excedente
        $valorexcedente = round($pesoexcedente * $dadosTabela['excedente'], 2);

        // Taxa extra da MINITA (na tabela também tem)
        $taxaextra = $p['taxaextra'];

        // Desconto dado na hora da emissão da MINUTA
        $desconto = $p['desconto'];

        // Valores das notas fiscais
        $notasvalor = explode('|', $p['notasvalor']);
        $valornotas = array_sum($notasvalor);

        // Valores das notas fiscais
        $notasvolumes = explode('|', $p['notasvolumes']);
        $totalvolumes = array_sum($notasvolumes);

        // Calculos da Tabela
        $tabela_fretevalor = round($dadosTabela['fretevalor'] * $valornotas / 100,
            2);
        $tabela_despacho   = $dadosTabela['despacho'];
        $tabela_seccat     = $dadosTabela['seccat'];
        $tabela_itr        = $dadosTabela['itr'];
        $tabela_gris       = round($dadosTabela['gris'] * $valornotas / 100, 2);
        $tabela_pedagio    = $dadosTabela['pedagio'];
        $tabela_outros     = $dadosTabela['outros'];

        // Calculo Frete Total
        $fretetotal = $valorminimo + $valorexcedente + $taxaextra - $desconto +
            $tabela_fretevalor + $tabela_despacho + $tabela_seccat + $tabela_itr
            +
            $tabela_gris + $tabela_pedagio + $tabela_outros;

        // Insere as variáveis uteis no array de retorno
        $this->calculo['peso']              = ($peso == '') ? '0.00' : number_format($peso,
                2, '.', '');
        $this->calculo['pesoexcedente']     = ($pesoexcedente == '') ? '0.00' : number_format($pesoexcedente,
                2, '.', '');
        $this->calculo['valorminimo']       = ($valorminimo == '') ? '0.00' : number_format($valorminimo,
                2, '.', '');
        $this->calculo['valorexcedente']    = ($valorexcedente == '') ? '0.00' : number_format($valorexcedente,
                2, '.', '');
        $this->calculo['taxaextra']         = ($taxaextra == '') ? '0.00' : number_format($taxaextra,
                2, '.', '');
        $this->calculo['desconto']          = ($desconto == '') ? '0.00' : number_format($desconto,
                2, '.', '');
        $this->calculo['valornotas']        = ($valornotas == '') ? '0.00' : number_format($valornotas,
                2, '.', '');
        $this->calculo['totalvolumes']      = $totalvolumes;
        $this->calculo['tabela_fretevalor'] = ($tabela_fretevalor == '') ? '0.00'
                : number_format($tabela_fretevalor, 2, '.', '');
        $this->calculo['tabela_despacho']   = ($tabela_despacho == '') ? '0.00' : number_format($tabela_despacho,
                2, '.', '');
        $this->calculo['tabela_seccat']     = ($tabela_seccat == '') ? '0.00' : number_format($tabela_seccat,
                2, '.', '');
        $this->calculo['tabela_itr']        = ($tabela_itr == '') ? '0.00' : number_format($tabela_itr,
                2, '.', '');
        $this->calculo['tabela_gris']       = ($tabela_gris == '') ? '0.00' : number_format($tabela_gris,
                2, '.', '');
        $this->calculo['tabela_pedagio']    = ($tabela_pedagio == '') ? '0.00' : number_format($tabela_pedagio,
                2, '.', '');
        $this->calculo['tabela_outros']     = ($tabela_outros == '') ? '0.00' : number_format($tabela_outros,
                2, '.', '');
        $this->calculo['fretetotal']        = ($fretetotal == '') ? '0.00' : number_format($fretetotal,
                2, '.', '');

        //Yii::$app->response->format = 'json';
        return $this->calculo;
        //return $dadosTabela;
    }
}