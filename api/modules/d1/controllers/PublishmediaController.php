<?php

namespace api\modules\d1\controllers;
use api\modules\d1\controllers\RestController;
use yii\base\BaseObject;
use yii\web\NotFoundHttpException;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\data\ActiveDataFilter;

use api\modules\d1\models\PublishmediaSearch;

//class InterviewController extends ActiveController
class PublishmediaController extends RestController
{
    public $modelClass = 'api\modules\d1\models\PublishMedia';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        

        $this->modelClass = new BaseObject();
        if(class_exists('api\modules\d1\models\PublishMedia'))
            $this->modelClass = 'api\modules\d1\models\PublishMedia';
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
                $query->joinWith('interview');
                $query->where('interview.published=1');

                $filter = new ActiveDataFilter([
                    'searchModel' => 'api\modules\d1\models\PublishmediaSearch',
                    'attributeMap'=> [ 'id'=>'publishmedia.id',
                    
                    ]
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
                
                $query = $modelClass::find(); 
                $query->joinWith('interview');
                $query->where('interview.published=1');

                $model = $query->where(['publishmedia.id'=>$id])->one();

                if ($model === null) {
                    throw new NotFoundHttpException("Object not found or not published: $id");
                }
                return $model;
            },
		];

		return $actions;
    }
    /**
     * Rest Description: PublisheMedia records endpoint; Fields with filter[fieldname][like]= contain search also have filter[fieldname]= for exact match, id field and fields with 1/0 value only have filter[fieldname]=, String and Date fields have both filter[fieldname][like]= and filter[fieldname]=; Other parameters include page: page number, per-page: number of records per page, status = ['0' => 'In Progresss', '1' => 'Accessed'], mediaType = ['1' => 'Video', '2' => 'Audio']; For nested entities use expand.
     * Rest Fields: ['field1', 'field2'].
     * Rest Filters: ['filter[id]', 'filter[accessName][like]','filter[accessionDate][like]',
     * 'filter[youtubeUrl][like]','filter[youtubeDes][like]','filter[status]','filter[interviewId]','filter[mediaType]',
     * 'filter[size]','filter[length]'].
     * Rest Expand: ['interview','transcriptions'].
     */
    public function actionIndex(){

    }
    
    public function actionView($id){
       
    }
   
}