<?php

use \yii\web\Request;

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);
$backEndBaseUrl = str_replace('/frontend/web', '/backend/web', (new Request)->getBaseUrl());


return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'frontend\models\PilotFrontUser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'loginUrl' => ['/login'],
        ],
        'session' => [
// this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        'jquery.min.js',
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        'js/bootstrap.min.js',
                    ]
                ]
            ],
//      'appendTimestamp' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//      'rules' => [
//        '/<comp>' => 'site/index',
//        '<comp>/<challenge>/signup' => 'site/signup',
//        '<comp>/login' => 'site/login',
//        '<comp>/request-password-reset' => 'site/request-password-reset',
//        '<comp>/reset-password' => 'site/reset-password',
//        '<comp>/my-profile' => 'site/my-profile',
//        '<comp>/terms-condition' => 'site/terms-condition',
//        '<comp>/privacy-policy' => 'site/privacy-policy',
//        '<comp>/challenge/<name>' => 'site/challenge',
//      ],
            'rules' => [
                '/' => 'site/index',
                '/<challenge>/signup' => 'site/signup',
                //'/aboveandbeyond/signup' => 'site/signup',
                '/login' => 'site/login',
                '/request-password-reset' => 'site/request-password-reset',
                '/reset-password' => 'site/reset-password',
                '/my-profile' => 'site/my-profile',
                '/terms-condition' => 'site/terms-condition',
                '/privacy-policy' => 'site/privacy-policy',
                '/<name>' => 'site/challenge',
              //  '/aboveandbeyond' => 'site/challenge',
                '/aboveandbeyond/<action>' => 'leads/<action>',
                '/learning/<action>' => 'test/<action>',
            ],
        ],
    ],
    'params' => $params,
];
