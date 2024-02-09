<?php

namespace api\modules\d1\controllers;
use api\modules\d1\controllers\RestController;
use yii\base\BaseObject;
use yii\web\NotFoundHttpException;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\data\ActiveDataFilter;

use api\modules\d1\models\PronounSearch;

//class InterviewController extends ActiveController
class PronounController extends RestController
{
    public $modelClass = 'api\modules\d1\models\Pronoun';

    
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        

        $this->modelClass = new BaseObject();
        if(class_exists('api\modules\d1\models\Pronoun'))
            $this->modelClass = 'api\modules\d1\models\Pronoun';
        else
            throw new NotFoundHttpException('Requested API not found.');

        parent::init();
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete']);

		$actions['index'] = [
			'class' => 'yii\rest\IndexAction',
			'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
			'prepareDataProvider' => function () {
                $model = new $this->modelClass;
                
                
                $query = $model::find(); 

                $filter = new ActiveDataFilter([
                    'searchModel' => 'api\modules\d1\models\PronounSearch',
                    
                ]);
                
                $filterCondition = null;
                
                // You may load filters from any source. For example,
                // if you prefer JSON in request body,
                // use Yii::$app->request->getBodyParams() below:
                if ($filter->load(\Yii::$app->request->get())) { 
                    $filterCondition = $filter->build();
                    if ($filterCondition === false) {
                        // Serializer would get errors out of it
                        return $filter;
                    }
                }
                
                if ($filterCondition !== null) {
                    $query->andWhere($filterCondition);
                }
                $dataProvider = new ActiveDataProvider([
					'query' => $query,
                    
				]);                
                return $dataProvider;
			},
		];

        $actions['view'] = [
			'class' => 'yii\rest\ViewAction',
			'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'findModel' => static function ($id, \yii\rest\ViewAction $action) {
                $modelClass = $action->modelClass;
                
            
                $model = $modelClass::find()->where(['id'=>$id])->one();
                
                if ($model === null) {
                    throw new NotFoundHttpException("Object not found or not published: $id");
                }
                return $model;
            },
		];

		return $actions;
    }
    /**
     * Rest Description: Pronoun records endpoint; Fields with filter[fieldname][like]= contain search also have filter[fieldname]= for exact match, id field and fields with 1/0 value only have filter[fieldname]=, String and Date fields have both filter[fieldname][like]= and filter[fieldname]=; Other parameters include page: page number, per-page: number of records per page; For nested entities use expand.
     * Rest Fields: ['field1', 'field2'].
     * Rest Filters: ['filter[id]', 'filter[value][like]'].
     * Rest Expand: ['interviews'].
     */
    public function actionIndex(){

    }
    
    public function actionView($id){
        
    }
   
}