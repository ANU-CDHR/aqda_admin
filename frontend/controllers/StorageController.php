<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Storage;
use frontend\models\Interview;
use frontend\models\PublishMedia;
use frontend\models\StorageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

use yii\db\Query;
use frontend\models\Format;
use frontend\models\Storageformat;

/**
 * StorageController implements the CRUD actions for Storage model.
 */
class StorageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    
                    [
                        'allow' => false, //deny for anonymous users
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true, //allow for login users
                        'roles' => ['@'],
                    ] 
                    
                ],
            ],
        ];
    }

    /**
     * Lists all Storage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StorageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

     /**
     * Lists all Storage models for publishmedia.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new StorageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $interviewId = Yii::$app->request->queryParams["interviewId"];
        $interview = Interview::findOne($interviewId);
        $mediaId = Yii::$app->request->queryParams["mediaId"];
        $publishmedia = PublishMedia::findOne($mediaId);

        if(isset(Yii::$app->request->queryParams['StorageSearch']))
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getStorages()->andFilterWhere(Yii::$app->request->queryParams['StorageSearch']),
            ]);
        else
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getStorages(),
            ]); 

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mediaId' => $mediaId, 'publishMedia'=>$publishmedia, 'interviewId'=>$interviewId
        ]);

    }

    /**
     * Displays a single Storage model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single Storage model for publishmedia.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionListview($id)
    {
        $searchModel = new StorageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $interviewId = Yii::$app->request->queryParams["interviewId"];
        $interview = Interview::findOne($interviewId);
        $mediaId = Yii::$app->request->queryParams["mediaId"];
        $publishmedia = PublishMedia::findOne($mediaId);

        if(isset(Yii::$app->request->queryParams['StorageSearch']))
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getStorages()->andFilterWhere(Yii::$app->request->queryParams['StorageSearch']),
            ]);
        else
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getStorages(),
            ]); 
        $model = $this->findModel($id);
        $model->lengthText = $this->sec2length($model->length);
        return $this->render('listview', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,'mediaId' => $mediaId, 'publishMedia'=>$publishmedia, 'interviewId'=>$interviewId
        ]);
    }

    /**
     * Creates a new Storage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Storage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Storage model for publishmedia.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionListcreate()
    {
        $model = new Storage();
        $searchModel = new StorageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $interviewId = Yii::$app->request->queryParams["interviewId"];
        $interview = Interview::findOne($interviewId);
        $mediaId = Yii::$app->request->queryParams["mediaId"];
        $publishmedia = PublishMedia::findOne($mediaId);

        if(isset(Yii::$app->request->queryParams['StorageSearch']))
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getStorages()->andFilterWhere(Yii::$app->request->queryParams['StorageSearch']),
            ]);
        else
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getStorages(),
            ]); 

        if ($publishmedia!=null && $model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $model->mediaId = $mediaId;
            $model->length = $this->length2sec($model->lengthText);
            if($model->save()){
                $id=$model->id;
                $storageformats = $post['Storage']['format'];
                //delete old formats
                $existingIss = Storageformat::find()
                                    ->where(['storageId' => $id])
                                    ->all();
                foreach($existingIss as $iss){
                    $iss->delete();
                }
                if($storageformats!==null&&is_array($storageformats))
                foreach($storageformats as $ss){
                    //if is not number - user filled Pronouns
                    if(!is_numeric(trim($ss))){
                        $existingis = Format::find()
                                    ->where(['value' => trim($ss)])
                                    ->one();
                        //double check: format aleady exists, link it to interview by adding to storageformat table
                        if($existingSs!=null&&$existingSs->id!=null){
                            $newIss = new Storageformat();
                            $newIss->storageIde = $id;
                            $newIss->formatId = $existingSs->id;
                            $newIss->save();
                        }
                    }else{
                        //is number find the format by id
                        $existingSs = Format::find()
                                    ->where(['id' => trim($ss)])
                                    ->one(); 
                        //link it to interview by adding to Interviewsexo table
                        if($existingSs!=null&&$existingSs->id!=null){
                            $newIss = new Storageformat();
                            $newIss->storageId = $id;
                            $newIss->formatId = $existingSs->id;
                            $newIss->save();
                        }
                    }
                }
                return $this->redirect(['listview', 'id' => $model->id, 'mediaId' => $mediaId, 'interviewId'=>$interviewId]);
            }
        }

        return $this->render('listcreate', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,'mediaId' => $mediaId, 'publishMedia'=>$publishmedia, 'interviewId'=>$interviewId
        ]);
    }

    /**
     * Updates an existing Storage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


     /**
     * Updates an existing Storage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionListupdate($id)
    {
        $model = $this->findModel($id);
        $searchModel = new StorageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $interviewId = Yii::$app->request->queryParams["interviewId"];
        $interview = Interview::findOne($interviewId);
        $mediaId = Yii::$app->request->queryParams["mediaId"];
        $publishmedia = PublishMedia::findOne($mediaId);

        if(isset(Yii::$app->request->queryParams['StorageSearch']))
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getStorages()->andFilterWhere(Yii::$app->request->queryParams['StorageSearch']),
            ]);
        else
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getStorages(),
            ]); 
            
        if ($publishmedia!=null && $model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $model->mediaId = $mediaId;
            $model->length = $this->length2sec($model->lengthText);
            if($model->save()){
                $storageformats = $post['Storage']['format'];
                //delete old formats
                $existingIss = Storageformat::find()
                                    ->where(['storageId' => $id])
                                    ->all();
                foreach($existingIss as $iss){
                    $iss->delete();
                }
                if($storageformats!==null&&is_array($storageformats))
                foreach($storageformats as $ss){
                    //if is not number - user filled Pronouns
                    if(!is_numeric(trim($ss))){
                        $existingis = Format::find()
                                    ->where(['value' => trim($ss)])
                                    ->one();
                        //double check: format aleady exists, link it to interview by adding to storageformat table
                        if($existingSs!=null&&$existingSs->id!=null){
                            $newIss = new Storageformat();
                            $newIss->storageIde = $id;
                            $newIss->formatId = $existingSs->id;
                            $newIss->save();
                        }
                    }else{
                        //is number find the format by id
                        $existingSs = Format::find()
                                    ->where(['id' => trim($ss)])
                                    ->one(); 
                        //link it to interview by adding to Interviewsexo table
                        if($existingSs!=null&&$existingSs->id!=null){
                            $newIss = new Storageformat();
                            $newIss->storageId = $id;
                            $newIss->formatId = $existingSs->id;
                            $newIss->save();
                        }
                    }
                }
                return $this->redirect(['listview', 'id' => $model->id, 'mediaId' => $mediaId, 'interviewId'=>$interviewId]);

            }
        }

        return $this->render('listupdate', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,'mediaId' => $mediaId, 'publishMedia'=>$publishmedia, 'interviewId'=>$interviewId
        ]);
    }


    /**
     * Lists all format models for dropdown.
     * @return mixed
     */
    public function actionFormatlist($q = null, $id = null){
        //$visitors = ArrayHelper::map(Visitor::find()->orderBy('name')->all(),'id', 'name'); 
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, value AS text')
                ->from('format')
                ->orderBy('value')
                //->where(['like', 'name', $q])
                ->where('value like :q', [':q' => '%'.$q.'%'])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Format::find($id)->value];
        }
        return $out;
    }


    /**
     * Deletes an existing Storage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $storage = $this->findModel($id);
        $publishMedia = $storage->media;
        $interview = $publishMedia->interview;
        
        //delete storage format links
        $storageformats = $storage->storageformats;
        foreach($storageformats as $storageformat ){
            $storageformat->delete();
        }
        $storage->delete();

        return $this->redirect(['list','mediaId'=>$publishMedia->id,'interviewId'=>$interview->id ]);
    }

    /**
     * Finds the Storage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Storage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Storage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * transfer seconds to HH:MM:SS format.
     * @param integer $seconds
     */
    private function sec2length($seconds) {
        //if(!$seconds) return "00:00:00";
        $t = round($seconds);
        return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
    }
    /**
     * transfer HH:MM:SS format to seconds.
     * @param string $length
     */
    private function length2sec($length){
        list($hours,$mins,$secs) = explode(':',$length);
        return $hours*3600+$mins*60+$secs;
    }
}
