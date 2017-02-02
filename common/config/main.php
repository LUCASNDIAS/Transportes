<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
	'db' => [
	    'class' => 'yii\db\Connection',
	    'dsn' => 'mysql:host=localhost;dbname=yiiplus',
	    'username' => 'root',
	    'password' => 'tligwww15',
	    'charset' => 'utf8',
	],
    ],
];
