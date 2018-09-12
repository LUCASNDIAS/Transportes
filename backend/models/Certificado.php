<?php

namespace backend\models;

use Yii;
use NFePHP\Common\Configure\Configure;


class Certificado
{

    public function certCheck($cliente) {

        $cnpj = $cliente;
        $pathCertsFiles = '/var/www/html/sped/certs';
        $certPfxName = $cliente . '.p12';
        $certPassword = 'Tlimp1';
        $certPhrase = '';

        $aResp = Configure::checkCerts($cnpj, $pathCertsFiles, $certPfxName, $certPassword);

        return $aResp;
    }

}