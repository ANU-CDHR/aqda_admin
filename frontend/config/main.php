<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    //'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    //usuario
    'bootstrap' => ['user'],
    'modules' => [
        //usuario
        'user' => [
            'class' => Da\User\Module::className(),
            'classMap' => [
                'User' => frontend\models\User::class,
                //'Profile' => frontend\models\Profile::class,
            ],
            'administratorPermissionName' => 'SysAdmin',
            //'administrators' => ['admin'],
            'enableGdprCompliance'=>true,
            'gdprPrivacyPolicyUrl'=>'',
            'allowAccountDelete'=>false,
            'gdprAnonymizePrefix'=>'DeletedUser',
            'gdprExportProperties'=>[
                'email',
                'username',
                'profile.public_email',
                'profile.name',
                'profile.gravatar_email',
                'profile.location',
                'profile.website',
                'profile.bio'
            ],
            'enableRegistration'=>false,
            'allowPasswordRecovery'=>true,
            'generatePasswords' => true,
            'enableEmailConfirmation'=>false,
            
        ], 
        
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',

        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@Da/User/resources/views/profile' => '@app/views/profile',
                ],
            ],
        ],
        /*'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],*/
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
       
        'youtube' => [
            'class' => \sr1871\youtubeApi\components\YoutubeApi::className(),

            'clientId' => '',
            'clientSecret' => '',
            'setAccessTokenFunction' => function($client){ file_put_contents('', json_encode($client->getAccessToken()));
             }, //anonymous function where save the accesToken, for YouTube API application
            'getAccessTokenFunction' => function(){ return file_get_contents('');}, // an anonymous function where get the accessToken 
            'scopes' => ['https://www.googleapis.com/auth/youtube.upload'],
            
        ],
        
        
    ],
    'params' => $params,
];
