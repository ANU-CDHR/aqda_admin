<?php

namespace api\modules\d1\controllers;
use api\modules\d1\controllers\RestController;
use yii\base\BaseObject;
use yii\web\NotFoundHttpException;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\data\ActiveDataFilter;


//class InterviewController extends ActiveController
class StorageController extends RestController
{
    public $modelClass = 'api\modules\d1\models\Storage';

    
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        

        $this->modelClass = new BaseObject();
        if(class_exists('api\modules\d1\models\Storage'))
            $this->modelClass = 'api\modules\d1\models\Storage';
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
                $query->joinWith('publishmedia')->joinWith('publishmedia.interview');
                $query->where('interview.published=1');

                $filter = new ActiveDataFilter([
                    'searchModel' => 'api\modules\d1\models\StorageSearch',
                    'attributeMap'=> [ 'id'=>'storage.id',
                        'accessName'=>'storage.accessName',
                        'length'=>'storage.length',
                        'size'=>'storage.size',
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
                $query->joinWith('publishmedia')->joinWith('publishmedia.interview');
                $query->where('interview.published=1');

                $model = $query->where(['storage.id'=>$id])->one();
                
                if ($model === null) {
                    throw new NotFoundHttpException("Object not found or not published: $id");
                }
                return $model;
            },
		];

		return $actions;
    }
    /**
     * Rest Description: Storage records endpoint; Fields with filter[fieldname][like]= contain search also have filter[fieldname]= for exact match, id field and fields with 1/0 value only have filter[fieldname]=, String and Date fields have both filter[fieldname][like]= and filter[fieldname]=; Other parameters include page: page number, per-page: number of records per page, storageType = ['1' => 'Master', '2' => 'Access']; For nested entities use expand.
     * Rest Fields: ['field1', 'field2'].
     * Rest Filters: ['filter[id]', 'filter[accessName][like]','filter[location][like]','filter[fileName][like]',
     * 'filter[createTime][like]','filter[notes][like]','filter[equipment][like]','filter[storageType]','filter[size]','filter[length]',
     * 'filter[uncompressedSize]','filter[noOfFiles]','filter[mediaId]'].
     * Rest Expand: ['publishmedia'].
     */
    public function actionIndex(){

    }
    
    public function actionView($id){
        
    }
   
}