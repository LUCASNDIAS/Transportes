<?php

namespace backend\models;

use NFePHP\CTe\Tools;
use Yii;
use NFePHP\Common\Configure\Configure;


class Certificado
{

    public function certCheck($cliente)
    {

        $cnpj = $cliente;
        $pathCertsFiles = '/var/www/html/sped/certs';
        $certPfxName = $cliente . '.pfx';
        $certPassword = '1234';
        $certPhrase = '';

        $aResp = Configure::checkCerts($cnpj, $pathCertsFiles, $certPfxName, $certPassword);

        return $aResp;
    }

    /**
     * ValidCerts
     * Verifica a data de validade do certificado digital
     * e compara com a data de hoje.
     * Caso o certificado tenha expirado o mesmo será removido das
     * pastas e o método irá retornar false.
     * @param string $pubKey chave publica
     * @return boolean
     */
    public function validCerts()
    {

        $cteTools = new Tools(Yii::getAlias('@sped/config/').Yii::$app->user->identity['cnpj'].'.json');

        //Caminho do Certificado
        $pfxCertPrivado = Yii::getAlias('@certs/') . Yii::$app->user->identity->cnpj . '.p12';
        if (!is_file($pfxCertPrivado)) {
            $pfxCertPrivado = Yii::getAlias('@certs/') . Yii::$app->user->identity->cnpj . '.pfx';
        }
        $cert_password = $cteTools->aConfig['certPassword'];

        if (!file_exists($pfxCertPrivado)) {
            $msg['erro'] = "Certificado não encontrado!! " . $pfxCertPrivado;
        }

        $pfxContent = file_get_contents($pfxCertPrivado);

        if (!openssl_pkcs12_read($pfxContent, $x509certdata, $cert_password)) {
            $msg['erro'] = "O certificado não pode ser lido!!";
        } else {

            $CertPriv = array();
            $CertPriv = openssl_x509_parse(openssl_x509_read($x509certdata['cert']));

            $PrivateKey = $x509certdata['pkey'];

            $pub_key = openssl_pkey_get_public($x509certdata['cert']);
            $keyData = openssl_pkey_get_details($pub_key);

            $PublicKey = $keyData['key'];

            $msg = [
                'status' => true,
                'msg' => 'Certificado Válido.',
                'validade' => date('d/m/Y', $CertPriv['validTo_time_t']),
                'erro' => ''
            ];

        }

        return $msg;
    }

}