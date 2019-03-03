<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/local/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/local/params-local.php')
);

return [
    'id'          => 'app-frontend',
    'name'        => 'Frontend',
    'basePath'    => dirname(__DIR__),
    'bootstrap'   => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components'  => [
        'reCaptcha' => [
            'name'    => 'reCaptcha',
            'class'   => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => $params['google_recaptcha']['siteKey'],
            'secret'  => $params['google_recaptcha']['secretKey'],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
//            'identityClass' => 'common\models\User',
            'identityClass'   => 'frontend\models\User',
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => true,
            'rules'               => [

                'news/category/<categoryId:\d+>/tag/<selectedTags:\w+>' => 'site/index',
                'news/category/<categoryId:\d+>'                        => 'site/index',
                'news/tag/<selectedTags:\w+>'                           => 'site/index',
                'news/page/<page:\d+>-<per-page:\d>'                    => 'site/index',
                'news'                                                  => 'site/index',
                '/'                                                     => 'site/index',

                'article/<id:\d+>'                                      => 'news/view',


                '<controller:\w+>/<id:\d+>'                             => '<controller>/view',
                //'<controller:\w+>/<action:\w+>/<id:\d+>'              => '<controller>/view',
                '<controller:\w+>/<action:\w+>'                         =>'<controller>/<action>',
                '<action:\w+>'                                          => 'site/<action>',
            ],
        ],
    ],
    'params' => $params,
];
