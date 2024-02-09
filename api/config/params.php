<?php
return [
    'adminEmail' => 'admin@example.com',
    'api' => [
        'class' => 'wdmg\api\Module',
        'routePrefix' => 'adminapi', // routing prefix for dashboard
        'accessTokenExpire' => 0, //3600  lifetime of 'access_token', '0' - unlimited
        'blockedIp' => [], // array, blocked access from IP`s
        'rateLimit' => 30, // request`s to API per minute
        'rateLimitHeaders' => false, // send HTTP-headers of rate limit
        'sendAccessToken' => true, // send access token with HTTP-headers
        'authMethods' => [ // auth methods to allow
            'basicAuth' => false,
            'bearerAuth' => false,
            'paramAuth' => true
        ],
        'allowedApiModes' => [ // allowed API modes
            'public' => false,
            'private' => true
        ],
        'allowedApiModels' => [ // allowed API models
            /*'public' => [
                "api\modules\d1\models\Interview"  => true,
                "api\modules\d1\models\Interviewer"  => true,
                "api\modules\d1\models\Narrator"  => true,
                "api\modules\d1\models\PublishMedia"  => true,
                "api\modules\d1\models\Interviewee"  => true,
                
            ],*/
            'private' => [
                "api\modules\d1\models\Interview"  => true,
                "api\modules\d1\models\Interviewer"  => true,
                "api\modules\d1\models\Narrator"  => true,
                "api\modules\d1\models\PublishMedia"  => true,
                //"api\modules\d1\models\Storage"  => true,
                "api\modules\d1\models\Transcription"  => true,
                "api\modules\d1\models\Interviewee"  => true,
                "api\modules\d1\models\Pronoun"  => true,
                "api\modules\d1\models\Sexo"  => true,
                "api\modules\d1\models\Gender"  => true,
                "api\modules\d1\models\MigrationStatus"  => true,
                "api\modules\d1\models\Language"  => true,
                
                
            ],
        ]
    ],
];
