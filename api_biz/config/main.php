<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')

);

return [
    'timeZone' => 'Asia/Chongqing',
    'id' => 'app-api-biz',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api_biz\controllers',

//    'on beforeRequest'=> function ($event) {
//        api\components\GlobalEvents::onBeginRequest($event);
//    },

//    'on afterRequest'=> function ($event) {
//        api\components\GlobalEvents::onEndRequest($event);
//    },

    'modules' => [
        'v1' => [
            'class' => 'api_biz\versions\v1\Module',
        ],
    ],

    'components' => [
        'user' => [
            'identityClass' => 'common\models\Channel',
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null
        ],
        'request' => [
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null && !isset($response->data['code']) && ($response->format !== 'html')) {
                    $response->format = \yii\web\Response::FORMAT_JSON;
                    $response->data = [
                        'code' => "0",
                        'data' => $response->data
                    ];
                }
            },
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
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
    ],
    'params' => $params,

];
