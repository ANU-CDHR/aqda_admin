<?php

namespace frontend\controllers;

use Yii;
use frontend\models\PublishMedia;
use frontend\models\PublishmediaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

use frontend\models\Interview;

/**
 * PublishmediaController implements the CRUD actions for PublishMedia model.
 */
class PublishmediaController extends Controller
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
     * Lists all PublishMedia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PublishmediaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all PublishMedia models for the interview.
     * @return mixed
     */
    public function actionList()
    {
        $interviewId = Yii::$app->request->queryParams["interviewId"];
        $interview = Interview::findOne($interviewId);
        $searchModel = new PublishmediaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(isset(Yii::$app->request->queryParams['PublishmediaSearch']))
            $dataProvider = new ActiveDataProvider([
                'query' => $interview->getPublishmedia()->andFilterWhere(Yii::$app->request->queryParams['PublishmediaSearch']),
            ]);
        else
            $dataProvider = new ActiveDataProvider([
                'query' => $interview->getPublishmedia(),
            ]);   

        return $this->render('list', [
            'interview' => $interview,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'interviewId'=>$interviewId
        ]);
    }

    /**
     * Displays a single PublishMedia model for interview.
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
     * Displays a single PublishMedia model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionListview($id)
    {
        $interviewId = Yii::$app->request->queryParams["interviewId"];
        $interview = Interview::findOne($interviewId);
        $searchModel = new PublishmediaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(isset(Yii::$app->request->queryParams['PublishmediaSearch']))
            $dataProvider = new ActiveDataProvider([
                'query' => $interview->getPublishmedia()->andFilterWhere(Yii::$app->request->queryParams['PublishmediaSearch']),
            ]);
        else
            $dataProvider = new ActiveDataProvider([
                'query' => $interview->getPublishmedia(),
            ]);   
        $model = $this->findModel($id);
        $model->lengthText = $this->sec2length($model->length);
        return $this->render('listview', [
            'model' => $model,
            'interviewId'=>$interviewId,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new PublishMedia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PublishMedia();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new PublishMedia model for interview.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionListcreate()
    {
        $model = new PublishMedia();
        $interviewId = Yii::$app->request->queryParams["interviewId"];
        $interview = Interview::findOne($interviewId);
        $searchModel = new PublishmediaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(isset(Yii::$app->request->queryParams['PublishmediaSearch']))
            $dataProvider = new ActiveDataProvider([
                'query' => $interview->getPublishmedia()->andFilterWhere(Yii::$app->request->queryParams['PublishmediaSearch']),
            ]);
        else
            $dataProvider = new ActiveDataProvider([
                'query' => $interview->getPublishmedia(),
            ]);   

            
        if ($interview!=null && $model->load(Yii::$app->request->post())) {
            $model->interviewId = $interviewId;
            $model->length = $this->length2sec($model->lengthText);  
            //upload youtube file if there is any
            if($model->files = UploadedFile::getInstance($model, 'files')){
                $model->save();
                $id=$model->id;
                if (!is_dir('uploads/media_'.$id)) {
                    mkdir('uploads/media_'.$id, 0755, true);
                }
                $newfile = 'uploads/media_'.$id.'/' . $model->files->baseName . '.' . $model->files->extension;  

                $model->files->saveAs($newfile);
                $model->files = null;

                $youtubeDes=$model->accessName;
                if($model->youtubeDes!=null&&trim($model->youtubeDes)!='')
                    $youtubeDes=$model->youtubeDes;
                $youtubeUrl = Yii::$app->youtube->uploadVideo($newfile, 
                [ 'title' => $model->interview->intervieweeName." ".$model->accessName, 'description' => $youtubeDes ], ['privacyStatus' => 'unlisted']);
                unlink($newfile);
                $youtubeUrlStr = $youtubeUrl->id;   
                print $youtubeUrlStr;
                if($youtubeUrlStr!=null&&trim($youtubeUrlStr)!='')    
                    $model->youtubeUrl='https://youtu.be/'.$youtubeUrlStr;    
                    
                
            }        
            if($model->save())
                return $this->redirect(['listview', 'id' => $model->id, 'interviewId'=>$interviewId]);
        }

        return $this->render('listcreate', [
            'interview' => $interview,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'interviewId'=>$interviewId,
        ]);
    }

     /**
     * Updates an existing PublishMedia model for interview.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionListupdate($id)
    {
        $model = $this->findModel($id);
        $interviewId = Yii::$app->request->queryParams["interviewId"];
        $interview = Interview::findOne($interviewId);
        $searchModel = new PublishmediaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(isset(Yii::$app->request->queryParams['PublishmediaSearch']))
            $dataProvider = new ActiveDataProvider([
                'query' => $interview->getPublishmedia()->andFilterWhere(Yii::$app->request->queryParams['PublishmediaSearch']),
            ]);
        else
            $dataProvider = new ActiveDataProvider([
                'query' => $interview->getPublishmedia(),
            ]);   

        if ($interview!=null && $model->load(Yii::$app->request->post())) {
             //upload youtube file if there is any
             if($model->files = UploadedFile::getInstance($model, 'files')){
                if (!is_dir('uploads/media_'.$id)) {
                    mkdir('uploads/media_'.$id, 0755, true);
                }
                $newfile = 'uploads/media_'.$id.'/' . $model->files->baseName . '.' . $model->files->extension;  
                $model->save();        
                $model->files->saveAs($newfile);
                $model->files = null;

                $youtubeDes=$model->accessName;
                if($model->youtubeDes!=null&&trim($model->youtubeDes)!='')
                    $youtubeDes=$model->youtubeDes;
                $youtubeUrl = Yii::$app->youtube->uploadVideo($newfile, 
                [ 'title' => $model->interview->intervieweeName." ".$model->accessName, 'description' => $youtubeDes ], ['privacyStatus' => 'unlisted']);
                unlink($newfile);
                $youtubeUrlStr = $youtubeUrl->id;   
                print $youtubeUrlStr;
                if($youtubeUrlStr!=null&&trim($youtubeUrlStr)!='')    
                    $model->youtubeUrl='https://youtu.be/'.$youtubeUrlStr;    
                    
                
            }
            $model->length = $this->length2sec($model->lengthText);
            if($model->save())
                return $this->redirect(['listview', 'id' => $model->id, 'interviewId'=>$interviewId]);
        }
        

        return $this->render('listupdate', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'interviewId'=>$interviewId,
        ]);
    }

    /**
     * Updates an existing PublishMedia model.
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
     * Test upload video for YouTube API plugin and application
     */
    public function actionUploadvideo(){
        Yii::$app->youtube->uploadVideo('uploads/music-box.mp4', 
        [ 'title' => 'video title', 'description' => 'description of the video' ], ['privacyStatus' => 'Unlisted']);
    }
    /**
     * Deletes an existing PublishMedia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $publishMedia = $this->findModel($id);
        $interviewId = $publishMedia->interview->id;
        
        $storages = $publishMedia->storages;
        $transcriptions = $publishMedia->transcriptions;
        foreach($storages as $storage){
            //delete storage format links
            $storageformats = $storage->storageformats;
            foreach($storageformats as $storageformat ){
                $storageformat->delete();
            }
            $storage->delete();
        }
        foreach($transcriptions as $transcription){
            $transcription->delete();
        }
        //delete media files and folder
        $this->deleteDir('uploads/media_'.$publishMedia->id.'/');
        $publishMedia->delete();


        return $this->redirect(['list', 'interviewId'=>$interviewId]);
    }
    /**
     * Deletes folder when deleting PublishMedia model.
     * @param string $dirPath
     */
    private static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            return;
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    /**
     * Finds the PublishMedia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PublishMedia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PublishMedia::findOne($id)) !== null) {
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
