<?php

//namespace wdmg\api\controllers;
namespace api\modules\d1\controllers;


use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\filters\AccessControl;
use yii\filters\RateLimiter;
use yii\rest\ActiveController;
use Yii;
use api\modules\d1\models\API;
use wdmg\users\models\Users;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;
use yii\web\ForbiddenHttpException;


class RestController extends ActiveController
{
    public $modelClass;
    private $requestMode = null;
    private $allowedModes = [];
    private $allowedModels = [];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;

        // Get request modes
        $this->requestMode = 'public';
        if (!empty(Yii::$app->request->get('access-token', false)))
            $this->requestMode = 'private';

    }

    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        $verbs = [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];

        if (!$this->requestMode == 'private') {
            unset($verbs['update']);
            unset($verbs['create']);
            unset($verbs['delete']);
        }

        return $verbs;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => []
        ];

        /*$behaviors['corsFilter'] = [
            'class' => '\yii\filters\Cors',
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];*/

        Yii::$app->response->headers->set('X-Access-Mode', $this->requestMode);
        //Yii::$app->response->headers->set('Access-Control-Request-Headers', '*');
        Yii::$app->response->headers->set('Access-Control-Allow-Origin', '*');
        //Yii::$app->response->headers->set('Access-Control-Request-Method', "'GET', 'POST', 'HEAD', 'OPTIONS'");
        
        //$apiModule = Yii::$app->getModule("api");
        // Get allowed modes
        if (isset(Yii::$app->params['api']['allowedApiModes']))
            $this->allowedModes = Yii::$app->params['api']['allowedApiModes'];
        else{ 
            $this->allowedModes = Yii::$app->controller->module->allowedApiModes;
        }
            
        // Get allowed models
        if (isset(Yii::$app->params['api']['allowedApiModels']))
            $this->allowedModels = Yii::$app->params['api']['allowedApiModels'];
        else
            $this->allowedModels = Yii::$app->controller->module->allowedApiModels;
            
        // Get auth methods
        if (isset(Yii::$app->params['api']['authMethods']))
            $authMethods = Yii::$app->params['api']['authMethods'];
        else
            $authMethods = Yii::$app->controller->module->authMethods;

        if ($this->requestMode == 'private' && isset($authMethods['basicAuth'])) {
            if ($authMethods['basicAuth'] == true)
                $behaviors['authenticator']['authMethods'][] = [
                    'class' => HttpBasicAuth::class,
                    'auth' => [$this, 'auth']
                ];
        }

        if ($this->requestMode == 'private' && isset($authMethods['bearerAuth'])) {
            if ($authMethods['bearerAuth'] == true)
                $behaviors['authenticator']['authMethods'][] = HttpBearerAuth::class;
        }
        $auth_allowed=false;
        if ($this->requestMode == 'private' && isset($authMethods['paramAuth'])) {
            if ($authMethods['paramAuth'] == true){
                /*$behaviors['authenticator']['authMethods'][] = [
                    'class'=> QueryParamAuth::class,
                    //'auth' => API::findIdentityByAccessToken(Yii::$app->request->get('access-token'))
                    //'tokenParam'=> Yii::$app->request->get('access-token')
                ];*/
                $auth_allowed = API::findIdentityByAccessToken(Yii::$app->request->get('access-token'));
            }
        }

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                'application/xml' => Response::FORMAT_XML,
            ],
        ];

        // Rate limit headers send?
        if (isset(Yii::$app->params['api']['rateLimitHeaders']))
            $rateLimitHeaders = intval(Yii::$app->params['api']['rateLimitHeaders']);
        else
            $rateLimitHeaders = Yii::$app->controller->module->rateLimitHeaders;

        if ($rateLimitHeaders == true)
            $behaviors['rateLimiter']['enableRateLimitHeaders'] = true;
        else
            $behaviors['rateLimiter']['enableRateLimitHeaders'] = false;

        // Get blocked IP`s
        if (isset(Yii::$app->params['api']['blockedIp']))
            $blockedIp = Yii::$app->params['api']['blockedIp'];
        else
            $blockedIp = Yii::$app->controller->module->blockedIp;

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ($this->requestMode == 'private'&&$auth_allowed) ? ['?','@'] : ['@'],
                    'matchCallback' => function ($rule, $action) use ($blockedIp, $auth_allowed) {
                        if (Yii::$app->request->userIP) {
                            if (is_array($blockedIp)) {
                                return (!in_array(Yii::$app->request->userIP, $blockedIp));
                            } else {
                                return (!strpos(Yii::$app->request->userIP, $blockedIp));
                            }
                        }
                        return true;
                    }
                ]
            ],
            'denyCallback' => function ($rule, $action) use ($auth_allowed) {
                if(!$auth_allowed)throw new ForbiddenHttpException('Requested invalid access token.', 0);
                throw new ForbiddenHttpException('Access to API has blocked.', -2);
            }
        ];

        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        $model = $this->modelClass;

        parent::checkAccess($action, $this->modelClass, $params);

        if ($this->requestMode == 'public' && isset($this->allowedModes['public'])) {
            if ($this->allowedModes['public'] == false)
                throw new ForbiddenHttpException('Access to all public API has disabled.', -2);
        } else if ($this->requestMode == 'private' && isset($this->allowedModes['private'])) {
            if ($this->allowedModes['private'] == false)
                throw new ForbiddenHttpException('Access to all private API has disabled.', -2);
        } else {
            throw new InvalidConfigException('Requested invalid configuration of API.', 0);
        }

        if ($this->requestMode == 'public') {
            if (isset($this->allowedModels['public']) && isset($this->allowedModels['public'][$model])) {
                if ($this->allowedModes['public'] == true && $this->allowedModels['public'][$model] == false)
                    throw new ForbiddenHttpException('Access to this public API has disabled.', -3);
            } else {
                throw new ForbiddenHttpException('Access to this API has not supported.', -1);
            }
        } else if ($this->requestMode == 'private') {
            
            if (isset($this->allowedModels['private']) && isset($this->allowedModels['private'][$model])) {
                if ($this->allowedModes['private'] == true && $this->allowedModels['private'][$model] === false)
                    throw new ForbiddenHttpException('Access to this private API has disabled.', -3);
            } else {
                throw new ForbiddenHttpException('Access to this API has not supported.'.json_encode($this->allowedModels['private']), -1);
            }
        } else {
            throw new ForbiddenHttpException('Access to API has blocked.', -2);
        }
    }

    /**
     * BaseAuth
     */
    public function auth($username, $password)
    {
        $user = Users::findOne(['username' => $username]);
        if ($user->validatePassword($password)) {
            $client = Api::findIdentity($user->id);
            if ($client) {

                // Send access token in header
                if (isset(Yii::$app->params['api']['sendAccessToken']))
                    $sendAccessToken = intval(Yii::$app->params['api']['sendAccessToken']);
                else
                    $sendAccessToken = Yii::$app->controller->module->sendAccessToken;

                if($sendAccessToken)
                    Yii::$app->response->headers->set('X-Access-Token', $client->access_token);

                return $client;
            }
            return null;
        }
        return null;
    }
}

?>