<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php')
    #require(__DIR__ . '/params-local.php')
);


return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log','documentation'],
    'modules' => [
        'd1' => [
            #'basePath' => '@app/modules/d1',
            'basePath' => dirname(__DIR__), 
            'class' => 'api\modules\d1\Module',
        ],
        //usuario
        'user' => [
            'class' => Da\User\Module::className(),
            'classMap' => [
                'User' => frontend\models\User::class,
                //'Profile' => frontend\models\Profile::class,
            ],
        ], 
        'documentation' => 'nostop8\yii2\rest_api_doc\Module',
        
    ],
    
    'components' => [        
        /*'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],*/
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'csrfCookie'=>array(
				'secure'=>true,
				'httpOnly'=>true,
				'sameSite'=>"Lax"
			),

        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','trace'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => ['d1/interview','d1/narrator','d1/interviewer','d1/publishmedia','d1/transcription','d1/pronoun','d1/sexo','d1/gender','d1/migration','d1/language'],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'except' => ['delete', 'create', 'update','view'],
                    
                ]
            ],        
        ],
        //usurio
        'authManager' => [
            'class' => 'Da\User\Component\AuthDbManagerComponent'
        ],
    ],
    'params' => $params,
];



