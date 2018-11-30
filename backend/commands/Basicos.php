<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\commands;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Basicos
{

    /**
     * Verifica permissões
     *
     * @param string $required A permissão requerida
     * @param array $user_permissions As permissões do usuário
     * @final
     */
    public function check_permissions(
        $required = 'any', $user_permissions = array('any')
    )
    {
        if (!is_array($user_permissions)) {
            return false;
        }

        // Se o usuário não tiver permissão
        if (!in_array($required, $user_permissions)) {
            // Retorna falso
            return false;
        } else {
            return true;
        }
    }

    /**
     * Altera as datas para visualização e para salvar
     * @param string $para Motivo da alteração (db ou ver)
     * @param unknownst string
     */
    public function formataData($para = 'db', $data)
    {
        if ($data !== null) {
            if ($para == 'db') {
                $sep_antes = '/';
                $sep_novo = '-';
            } else if ($para == 'boleto') {
                $sep_antes = '-';
                $sep_novo = '.';
            } else {
                $sep_antes = '-';
                $sep_novo = '/';
            }

            $exp = explode($sep_antes, $data);
            $nova_data = $exp[2] . $sep_novo . $exp[1] . $sep_novo . $exp[0];
            return $nova_data;
        } else {
            return null;
        }
    }

    /**
     * Public static extenso
     * @param type $value
     * @param type $uppercase
     * @return type
     */
    public static function extenso($value, $uppercase = 0)
    {
        if (strpos($value, ",") > 0) {
            $value = str_replace(".", "", $value);
            $value = str_replace(",", ".", $value);
        }
        $singular = ["centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão"];
        $plural = ["centavos", "reais", "mil", "milhões", "bilhões", "trilhões",
            "quatrilhões"];

        $c = ["", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos",
            "seiscentos", "setecentos", "oitocentos", "novecentos"];
        $d = ["", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta",
            "setenta", "oitenta", "noventa"];
        $d10 = ["dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis",
            "dezesete", "dezoito", "dezenove"];
        $u = ["", "um", "dois", "tres", "quatro", "cinco", "seis", "sete", "oito",
            "nove"];

        $z = 0;

        $value = number_format($value, 2, ".", ".");
        $integer = explode(".", $value);
        $cont = count($integer);
        for ($i = 0; $i < $cont; $i++)
            for ($ii = strlen($integer[$i]); $ii < 3; $ii++)
                $integer[$i] = "0" . $integer[$i];

        $fim = $cont - ($integer[$cont - 1] > 0 ? 1 : 2);
        $rt = '';
        for ($i = 0; $i < $cont; $i++) {
            $value = $integer[$i];
            $rc = (($value > 100) && ($value < 200)) ? "cento" : $c[$value[0]];
            $rd = ($value[1] < 2) ? "" : $d[$value[1]];
            $ru = ($value > 0) ? (($value[1] == 1) ? $d10[$value[2]] : $u[$value[2]])
                : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
                    $ru) ? " e " : "") . $ru;
            $t = $cont - 1 - $i;
            $r .= $r ? " " . ($value > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($value == "000"
            ) $z++;
            elseif ($z > 0) $z--;
            if (($t == 1) && ($z > 0) && ($integer[0] > 0))
                $r .= (($z > 1) ? " de " : "") . $plural[$t];
            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) &&
                        ($integer[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ")
                        : " ") . $r;
        }

        if (!$uppercase) {
            return trim($rt ? $rt : "zero");
        } elseif ($uppercase == "2") {
            return trim(strtoupper($rt) ? strtoupper(strtoupper($rt)) : "Zero");
        } else {
            return trim(ucwords($rt) ? ucwords($rt) : "Zero");
        }
    }

    public function formataCNPJ($cnpj)
    {
        $tipo = strlen($cnpj);

        $formato = ($tipo == 11) ? "%s%s%s.%s%s%s.%s%s%s-%s%s" : "%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s";

        return vsprintf($formato, str_split($cnpj));
    }

    public function boletoValor($valor)
    {
        if ($valor != 0) {
            $vl = number_format($valor, 2, '.', '');
            $junto = str_replace('.', '', $vl);
            return $junto;
        } else {
            return '0';
        }
    }

    public function boletoPercentual($valor)
    {
        if ($valor != 0) {
            $vl = explode('.', $valor);
            $inteiro = str_pad($vl[0],3,'0',STR_PAD_LEFT);
            $decimal = str_pad($vl[1],5,'0',STR_PAD_RIGHT);
            $junto = "$inteiro" . "$decimal";
            return $junto;
        } else {
            return '0';
        }
    }
}