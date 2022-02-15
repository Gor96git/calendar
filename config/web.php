<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'xxxx',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'errorHandler' => [
            'class' => \yii\web\ErrorHandler::class,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'OPTIONS,POST books' => 'book/create',
                'OPTIONS,PATCH books/<id:\d+>' => 'book/update',
                'OPTIONS,DELETE books/<id:\d+>' => 'book/delete',
                'OPTIONS,GET books' => 'book/index',
                'OPTIONS,POST login' => 'book/login',
                'OPTIONS,POST logout' => 'book/logout',
                'OPTIONS,GET books/<id:\d+>' => 'book/get'
            ],
        ],

    ],
    'params' => $params,
];

return $config;
