<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Transcription;
use frontend\models\Interview;
use frontend\models\PublishMedia;
use frontend\models\TranscriptionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * TranscriptionController implements the CRUD actions for Transcription model.
 */
class TranscriptionController extends Controller
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
     * Lists all Transcription models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TranscriptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

     /**
     * Lists all Transcription models for publishmedia.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new TranscriptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $interviewId = Yii::$app->request->queryParams["interviewId"];
        $interview = Interview::findOne($interviewId);
        $mediaId = Yii::$app->request->queryParams["mediaId"];
        $publishmedia = PublishMedia::findOne($mediaId);

        if(isset(Yii::$app->request->queryParams['TranscriptionSearch']))
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getTranscriptions()->andFilterWhere(Yii::$app->request->queryParams['TranscriptionSearch']),
            ]);
        else
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getTranscriptions(),
            ]); 

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mediaId' => $mediaId, 'publishMedia'=>$publishmedia, 'interviewId'=>$interviewId
        ]);

    }

    /**
     * Lists all Transcription models for publishmedia.
     * @return mixed
     */
    public function actionImport()
    {
        
        $interviewId = Yii::$app->request->queryParams["interviewId"];
        $interview = Interview::findOne($interviewId);
        $mediaId = Yii::$app->request->queryParams["mediaId"];
        $publishmedia = PublishMedia::findOne($mediaId);
        $model = new publishmedia();
        
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $open=true;
            $allsave=true;
            $message="";
            if($model->csv = UploadedFile::getInstance($model, 'csv')){
                if($model->csv==null||trim($model->csv)==""){
                    echo '<script>alert("Unable to open file. Import failed1.");</script>';
                    $open=false;
                }else{
                    $targetPath = "uploads/".$model->csv;
                    if($model->csv->saveAs($targetPath)){
                        ini_set('auto_detect_line_endings',TRUE);
                        $file_handle = fopen($targetPath, "r") or $open=false;
                        if(!$open){
                            echo '<script>alert("Unable to open file. Import failed2.");</script>';
                            $open=false;
                        }
                        $row=0;
                        $checkarray = ["Timestamp","Segment Title","Partial Transcription*","Keywords","Subject","Synopsis","GPS (Lat,Lng)"];
                        
                        while (($data = fgetcsv($file_handle, 1000, ",")) !== FALSE) {
                            if($row==0&&!($data===$checkarray)){
                                //var_dump($checkarray);
                                //var_dump($data);
                                //var_dump(array_diff($checkarray,$data));return;
                                echo '<script>alert(" Please check the column headers, make sure all fields are present.'.var_export(array_diff($data,$checkarray)).'");</script>';
                                $open=false;
                                break;
                                
                            }
                            if($row>0){
                                //check time format
                                
                                if($data!=null){
                                    $cansave=true;
                                    $timeCorrect=true;
                                    
                                    $newTran = new Transcription();
                                    $newTran->timestampText = "00:00:00";
                                    $newTran->timestamp = 0;
                                    if(isset($data[0])&&$data[0]!=null&&trim($data[0])!=""){
                                        
                                        if($this->checkTimestamp(trim($data[0]))){
                                            $newTran->timestampText = trim($data[0]);
                                            $newTran->timestamp = $this->length2sec(trim($data[0]));
                                        }else $timeCorrect=false;
                                        
                                    }
                                    if(isset($data[1])&&$data[1]!=null&&trim($data[1])!=""){
                                        $newTran->segmentTitle = utf8_encode(trim($data[1]));
                                    }
                                             
                                    if(isset($data[2])&&$data[2]!=null&&trim($data[2])!=""){
                                        $newTran->partialTranscription = utf8_encode(trim($data[2]));
                                    }else $cansave=false;

                                    if(isset($data[3])&&$data[3]!=null&&trim($data[3])!=""){
                                        $newTran->keywords = utf8_encode(trim($data[3]));
                                    }

                                    if(isset($data[4])&&$data[4]!=null&&trim($data[4])!=""){
                                        $newTran->subject = utf8_encode(trim($data[4]));
                                    }
                                    
                                    if(isset($data[5])&&$data[5]!=null&&trim($data[5])!=""){
                                        $newTran->synopsis = utf8_encode(trim($data[5]));
                                    }

                                    if(isset($data[6])&&$data[6]!=null&&trim($data[6])!=""){
                                        $newTran->gps = utf8_encode(trim($data[6]));
                                    }

                                    $newTran->mediaId = $mediaId;

                                    if(isset($data[0])&&isset($data[2]))
                                        if(!$cansave||!$timeCorrect){
                                            if(!$cansave){
                                                $message=$message.$row.":".$result = substr($data[2], 0, 10)." ".$data[0]." record's one or more compulsory fields are not filled, it can not be imported. \\n";
                                                $allsave=false;
                                            }
                                            if(!$timeCorrect){
                                                $message=$message.substr($data[2], 0, 10)." ".$data[0]." record's timestamp format is not correct, please check it is ##:##:##. The record can not be imported. \\n";
                                                $allsave=false;
                                            }
                                        }else{
                                            if($newTran->save()){
                                                //$message=$message.$row.":".$data[0]." ".$data[1]." record has been imported. \\n";
                                            }else{
                                                $message=$message.$row.":".substr($data[2], 0, 10)." ".$data[0]." record has not been imported for unknown reason. \\n";
                                                $allsave=false;
                                            }
                                        }
                                }
                            }
                            $row++;
                            
                        }
                        ini_set('auto_detect_line_endings',FALSE);
                        fclose($file_handle);
                        unlink($targetPath);
                        if(trim($message)!=""){
                             echo '<script>alert("'.$message.'");</script>';
                            if($allsave!=true) {
                                 return $this->render('import', [
                                    'mediaId' => $mediaId, 'publishMedia'=>$publishmedia, 'interviewId'=>$interviewId
                                ]);
                            }
                        }
                        
                    }else{
                        echo '<script>alert("Unable to open file. Import failed3.");</script>';
                          $open=false;   
                    }
                }
            }
            if(!$open){
                return $this->render('import', [
                    'mediaId' => $mediaId, 'publishMedia'=>$publishmedia, 'interviewId'=>$interviewId
                ]);
            }else
                return $this->redirect(['list', 'mediaId' => $mediaId, 'interviewId'=>$interviewId]);
        } else {
            return $this->render('import', [

                'mediaId' => $mediaId, 'publishMedia'=>$publishmedia, 'interviewId'=>$interviewId
            ]);
        }
    }
    /**
     * Check if timestamp format (00:00:00) is correct.
     * @param string $time
     * @return boolean
     */
    private function checkTimestamp($time){
        if (preg_match("/^(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])$/",$time)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Displays a single Transcription model.
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
     * Displays a single Transcription model for publishmedia.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionListview($id)
    {
        $searchModel = new TranscriptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $interviewId = Yii::$app->request->queryParams["interviewId"];
        $interview = Interview::findOne($interviewId);
        $mediaId = Yii::$app->request->queryParams["mediaId"];
        $publishmedia = PublishMedia::findOne($mediaId);

        if(isset(Yii::$app->request->queryParams['TranscriptionSearch']))
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getTranscriptions()->andFilterWhere(Yii::$app->request->queryParams['TranscriptionSearch']),
            ]);
        else
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getTranscriptions(),
            ]); 
        $model = $this->findModel($id);
        //$model->lengthText = $this->sec2length($model->length);
        //$model->timestampText = $this->sec2length($model->timestamp);
        return $this->render('listview', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,'mediaId' => $mediaId, 'publishMedia'=>$publishmedia, 'interviewId'=>$interviewId
        ]);
    }

    /**
     * Creates a new Transcription model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transcription();

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
        $model = new Transcription();
        $searchModel = new TranscriptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $interviewId = Yii::$app->request->queryParams["interviewId"];
        $interview = Interview::findOne($interviewId);
        $mediaId = Yii::$app->request->queryParams["mediaId"];
        $publishmedia = PublishMedia::findOne($mediaId);

        if(isset(Yii::$app->request->queryParams['TranscriptionSearch']))
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getTranscriptions()->andFilterWhere(Yii::$app->request->queryParams['TranscriptionSearch']),
            ]);
        else
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getTranscriptions(),
            ]); 

        if ($publishmedia!=null && $model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $model->mediaId = $mediaId;
            //$model->length = $this->length2sec($model->lengthText);
            $model->timestamp = $this->length2sec($model->timestampText);
            if($model->save()){
                
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
     * Updates an existing Transcription model.
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
     * Updates an existing Transcription model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionListupdate($id)
    {
        $model = $this->findModel($id);
        $searchModel = new TranscriptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $interviewId = Yii::$app->request->queryParams["interviewId"];
        $interview = Interview::findOne($interviewId);
        $mediaId = Yii::$app->request->queryParams["mediaId"];
        $publishmedia = PublishMedia::findOne($mediaId);

        if(isset(Yii::$app->request->queryParams['TranscriptionSearch']))
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getTranscriptions()->andFilterWhere(Yii::$app->request->queryParams['TranscriptionSearch']),
            ]);
        else
            $dataProvider = new ActiveDataProvider([
                'query' => $publishmedia->getTranscriptions(),
            ]); 
            
        if ($publishmedia!=null && $model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $model->mediaId = $mediaId;
            //$model->length = $this->length2sec($model->lengthText);
            $model->timestamp = $this->length2sec($model->timestampText);
            if($model->save()){
                
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
     * Deletes an existing Transcription model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $transcription = $this->findModel($id);
        $publishMedia = $transcription->media;
        $interview = $publishMedia->interview;
        
        $transcription->delete();

        return $this->redirect(['list','mediaId'=>$publishMedia->id,'interviewId'=>$interview->id ]);
    }

    /**
     * Deletes all Transcriptions from a publishemedia.
     * If deletion is successful, the browser will be redirected to the 'list' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteall($mediaId, $interviewId)
    {
        $publishMedia = PublishMedia::findOne($mediaId);
        
        if($publishMedia!=null){
            $transcriptions = $publishMedia->transcriptions;
            foreach($transcriptions as $transcription){
                $transcription->delete();
            }
        }

        return $this->redirect(['list','mediaId'=>$mediaId,'interviewId'=>$interviewId ]);
    }

    /**
     * Finds the Transcription model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transcription the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transcription::findOne($id)) !== null) {
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
        if($length!=''&&$length!=null){
        list($hours,$mins,$secs) = explode(':',$length);
        return $hours*3600+$mins*60+$secs;}
        else return 0;
    }
}
