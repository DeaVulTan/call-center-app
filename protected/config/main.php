<?php

Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');
Yii::setPathOfAlias('widgets', dirname(__FILE__) . '/../components/widgets');

return CMap::mergeArray([
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Astravox Call Center',
    'language' => 'ru',
    'sourceLanguage' => 'en',
    'preload' => [
        'log',
    ],
    'theme' => 'bootstrap',

    'import' => [
        'application.models.*',
        'application.components.*',
        'application.components.widgets.*',
        'application.modules.atc.components.*',
        'application.modules.*',
        'application.modules.auth.components.*',
        'application.modules.atc.models.*',
        'application.modules.callcenter.models.*',
        'application.extensions.phaActiveColumn.*',
        'application.extensions.bootstrap.*',
    ],

    'modules' => [
        'gii' => [
            'generatorPaths' => [
                'bootstrap.gii',
            ],
            'class' => 'system.gii.GiiModule',
            'password' => 'hfccdtnyfz10',
            'ipFilters' => ['*'],
        ],
        'atc',
        'callcenter',
        'smsmailer',
        'statistics',
        'settings',
        'auth' => [
            'userClass' => 'User',
            'userIdColumn' => 'id',
            'userNameColumn' => 'username',
        ],
    ],

    'components' => [
        'comet' => [
            'class' => 'CometComponent',
            'host' => 'astravox2',
            'port' => 8085,
        ],

        'bootstrap' => [
            'class' => 'bootstrap.components.Bootstrap',
        ],
        'user' => [
            'class' => 'WebUser',
            'allowAutoLogin' => true,
            'admins' => ['admin'],
        ],
        'authManager' => [
            'behaviors' => [
                'auth' => [
                    'class' => 'auth.components.AuthBehavior',
                ],
            ],
        ],
        'urlManager' => [
            'urlFormat' => 'path',
            'showScriptName' => false,
            'caseSensitive' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'db' => [
            'connectionString' => 'mysql:host=localhost;dbname=callcenter',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableParamLogging' => true,
            'enableProfiling' => true,
        ],
        'db_readonly' => [
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=192.168.0.23;dbname=callcenter',
            'emulatePrepare' => true,
            'username' => 'readonly',
            'password' => '',
            'charset' => 'utf8',
            'enableParamLogging' => true,
            'enableProfiling' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'class' => 'CLogRouter',
            'enabled' => YII_DEBUG,
            'routes' => [
                'file' => [
                    'class' => 'CFileLogRoute',
                    'logpath' => $_SERVER['DOCUMENT_ROOT'] . '/protected/data/logs',
                    'levels' => 'error, warning'
                ],
            ],
        ],
        'session' => [
            'class' => 'CDbHttpSession',
            'connectionID' => 'db',
            'sessionTableName' => 'user_session',
            'autoCreateSessionTable' => false,
            'timeout' => 300
        ],
        'cache' => [
            'class' => 'CMemCache',
            'servers' => [
                ['host' => '127.0.0.1', 'port' => 11211, 'weight' => 60],
            ],
        ],
        'image' => [
            'class' => 'ext.image.ImageComponent',
            'driver' => 'Gd',
        ],
        'message' => [
            'class' => 'MessageComponent',
        ],
        'op' => [
            'class' => 'OperatorPanelComponent',
        ],
        'notesSaver' => [
            'class' => 'NotesSaverComponent',
        ],
        'system' => [
            'class' => 'SystemComponent',
        ],
    ],
    'params' => require(dirname(__FILE__) . '/params.php'),
], require(dirname(__FILE__) . '/local.php'));
