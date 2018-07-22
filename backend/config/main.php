<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/local/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/local/params-local.php')
);

return [
    'id'                  => 'app-backend',
    'name'                => 'Backend',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap'           => ['log'],
    'modules'             => [],
    'components'          => [
        'reCaptcha' => [
            'name'    => 'reCaptcha',
            'class'   => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6Ld4smUUAAAAALsFHbbzSFYI9V6URxfIxibON_Ef',
            'secret'  => '6Ld4smUUAAAAACJiEBPtxdOCG47f_xNzgwSKfLSz',
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass'   => 'backend\models\Admin',
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'formatter' => [
            'class'           => 'yii\i18n\Formatter',
            'dateFormat'      => 'php:Y-m-d',
            'datetimeFormat'  => 'php:Y-m-d H:i:s',
            'timeFormat'      => 'php:H:i:s',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => true,
            'rules' => [
                '/'                                     => 'site/index',
                '<action>'                              => 'site/<action>',
                '<controller:\w+>/<id:\d+>'             =>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'         =>'<controller>/<action>'
            ],
        ],
    ],
    'params' => $params,
];
