<?php

namespace api\modules\d1\controllers;
use api\modules\d1\controllers\RestController;
use yii\base\BaseObject;
use yii\web\NotFoundHttpException;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\data\ActiveDataFilter;

use api\modules\d1\models\InterviewSearch;

//class InterviewController extends ActiveController
class InterviewController extends RestController
{
    public $modelClass = 'api\modules\d1\models\Interview';

   
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        

        $this->modelClass = new BaseObject();
        if(class_exists('api\modules\d1\models\Interview'))
            $this->modelClass = 'api\modules\d1\models\Interview';
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
                
                
                $query = $model::find()->where(['published'=>1]);

                $query->joinWith('language')->joinWith('migration')->joinWith('interviewee')->joinWith('interviewer');

                $filter = new ActiveDataFilter([
                    'searchModel' => 'api\modules\d1\models\InterviewSearch',
                    'attributeMap'=> [ 'id'=>'interview.id',
                        'languageName'=>'language.name', 
                        'migrationName'=>'migrationStatus.name', 
                        //'genderName'=>'gender.name',
                        'narratorName'=>'interviewee.name',
                        'intervieweeName'=>'interviewee.name',
                        'interviewerName'=>'interviewer.name'
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
            
                $model = $modelClass::find()->where(['id'=>$id,'published'=>1])->one();
                
                if ($model === null) {
                    throw new NotFoundHttpException("Object not found or not published: $id");
                }
                return $model;
            },
		];

		return $actions;
    }
    /**
     * Rest Description: Interview records endpoint; Fields with filter[fieldname][like]= contain search also have filter[fieldname]= for exact match, id field and fields with 1/0 value only have filter[fieldname]=, String and Date fields have both filter[fieldname][like]= and filter[fieldname]=; Other parameters include page: page number, per-page: number of records per page; For nested entities use expand.
     * Rest Fields: ['field1', 'field2'].
     * Rest Filters: ['filter[id]', 'filter[narratorName][like]','filter[interviewerName][like]',
     * 'filter[migrationName][like]','filter[intervieweeLocation][like]',
     * 'filter[date][like]','filter[languageName][like]','filter[escapeCountry][like]','filter[contextual][like]',
     * 'filter[accessionName][like]','filter[lat][like]','filter[lng][like]', 'filter[narratorNameD][like]',
     * 'filter[transgender]','filter[intervieweeId]','filter[interviewerId]','filter[isCitizen]',
     * 'filter[pseudonym]','filter[videoDistortion]','filter[voiceChange]','filter[refugeeCamp]'].
     * Rest Expand: ['narrator','interviewer','migration','language','pronouns','genders','sexo','publishMedia','publishMedia%2Etranscriptions','publishMedia%2Estorages'].
     */
    public function actionIndex(){

    }
    
    public function actionView($id)
    {
    }
   
}