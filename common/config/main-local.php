<?php

return [
    'language' => 'pt-br',
    //'timezone' => 'America/Sao_Paulo',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=lndsi581_geral',
            'username' => 'root',
            'password' => 'tligwww15',
            'charset' => 'utf8',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                //'fileMap' => [
                //	'app' => 'app.php',
                //'app/error' => 'error.php',
                //],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
//                'host' => 'br20.hostgator.com.br',
//                'username' => 'contato@lndsistemas.com.br',
//                'password' => 'Tlimp15*=', //'llqyulcgidhezbgo*=',
//                'port' => '465',
//                'encryption' => 'ssl',
                'host' => 'smtp.gmail.com',
                'username' => 'lndsistemas.mail@gmail.com',
                'password' => 'Tlimp15*=', //'llqyulcgidhezbgo*=',
                'port' => '587',
                'encryption' => 'tls',
            ],
            'useFileTransport' => false,
        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];
