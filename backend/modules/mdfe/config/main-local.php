<?php

// Cor do tema rotativa
/*
  $cor = rand(1,3);

  switch ($cor)
  {
  case 1:
  $tema = 'skin-red';
  break;
  case 2:
  $tema = 'skin-blue';
  break;
  case 3:
  $tema = 'skin-purple';
  break;
  default:
  $tema = 'skin-purple';
  }
 */

$config = [
//    'language' => 'pt-BR',
//    'timezone' => 'America/Sao_Paulo',
//    'modules' => [
//        'mdfe' => [
//            'class' => 'backend\modules\mdfe\Module',
//        ],
//    ],
    'components' => [
//        'request' => [
//            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
//            'cookieValidationKey' => 'G7Ktn_okvAGQh9aSNgQTmBoHMRaqFiBN',
//        ],
        'user' => [
            'class' => 'backend\models\Usuarios',
            'identityClass' => 'backend\models\Usuarios',
            'enableAutoLogin' => false,
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '/Transportes/backend/web',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '/Transportes/frontend/web',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'assetManager' => [
            'class' => 'dmstr\web\AdminLteAsset',
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => isset($tema) ? $tema : 'skin-purple',
                ],
            ],
        ],
        'html2pdf' => [
            'class' => 'yii2tech\html2pdf\Manager',
            'viewPath' => '@app/views',
            'converter' => [
                'class' => 'yii2tech\html2pdf\converters\Mpdf',
                'defaultOptions' => [
                    'pageSize' => 'A4'
                ],
            ]
        ],
    ],
];


// Tirei o debug da parte de Testes pra impressao pdf
if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    //$config['bootstrap'][] = 'debug';
    //$config['modules']['debug'] = [
    //    'class' => 'yii\debug\Module',
    //];

//    $config['bootstrap'][] = 'gii';
//    $config['modules']['gii'] = [
//        'class' => 'yii\gii\Module',
//    ];
}

return $config;
