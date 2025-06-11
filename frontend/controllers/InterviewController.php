<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Interview;
use frontend\models\Interviewee;
use frontend\models\InterviewSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\db\Query;
use yii\web\UploadedFile;


use frontend\models\Pronouns;
use frontend\models\Interviewpron;
use frontend\models\SexualOrientation;
use frontend\models\Interviewsexo;
use frontend\models\Interviewgender;
use frontend\models\Gender;
use Da\User\Model\User;
use yii\rest\ActiveController;

/**
 * InterviewController implements the CRUD actions for Interview model.
 */
class InterviewController extends Controller
//class InterviewController extends ActiveController
{
    public $modelClass = 'frontend\models\Interview';
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
                        'actions' => ['showimage'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['showimage'],
                        'allow' => true,
                        'roles' => ['?'],
                        'matchCallback' => function ($rule, $action) {
                            $model=$this->findModel(Yii::$app->request->get('id'));
                            return $model->published;
                        }
                    ],
                    
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
     * Lists all Interview models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InterviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Interview model.
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
     * Displays image of Interview model hidding real path.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionShowimage($id)
    {
        $model = $this->findModel($id);
        $file=Yii::getAlias('@uploads').'/interview_'.$model->id.'/'.$model->imageFile;
        //print $file;
        if (file_exists($file))
        {
            
            $response = Yii::$app->getResponse();
            if ( !is_resource($response->stream = fopen($file, 'r')) ) {
                throw new \yii\web\ServerErrorHttpException('file access failed: permission deny');
            }
            
            return $response->sendFile($file, $model->imageFile, [
                //'mimeType' => 'image/jpeg',
                'inline' => true,
            ]);
        }
    }

    /**
     * fields setting for Interview.
     * @return mixed
     */
    public function actionSettings()
    {

        return $this->render('settings');
    }
    /**
     * Lists all Pronouns models for dropdown.
     * @return mixed
     */
    public function actionPronounslist($q = null, $id = null){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, value AS text')
                ->from('pronouns')
                ->orderBy('value')
                ->where('value like :q', [':q' => '%'.$q.'%'])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Pronouns::find($id)->value];
        }
        return $out;
    }

    /**
     * Lists all SexualOrientation models for dropdown.
     * @return mixed
     */
    public function actionSexolist($q = null, $id = null){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, value AS text')
                ->from('sexualOrientation')
                ->orderBy('value')
                ->where('value like :q', [':q' => '%'.$q.'%'])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => SexualOrientation::find($id)->value];
        }
        return $out;
    }

    /**
     * Lists all Genders models for dropdown.
     * @return mixed
     */
    public function actionGenderlist($q = null, $id = null){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name AS text')
                ->from('gender')
                ->orderBy('name')
                ->where('name like :q', [':q' => '%'.$q.'%'])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Gender::find($id)->name];
        }
        return $out;
    }

    /**
     * Creates a new Interview model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Interview();
        $userId = Yii::$app->user->identity->id;
        $model->createUserId = $userId;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            #if narrator name empty set = interviewee name 
            if(!($model->narratorNameD!=null&&trim($model->narratorNameD)!='')){
                $model->narratorNameD=$model->intervieweeName;
                $model->save();
            }
            $id=$model->id;
            $post = Yii::$app->request->post();

            //save uploaded file if there is any
            if($model->files = UploadedFile::getInstance($model, 'files')){
                if (!is_dir('uploads/interview_'.$id)) {
                    mkdir('uploads/interview_'.$id, 0755, true);
                }
                $newfile = $model->files->baseName . '.' . $model->files->extension;
                $model->imageFile = $newfile;   
                if($newfile!=null&&trim($newfile)!='')        
                    $model->save();
                $model->files->saveAs('uploads/interview_'.$id.'/' . $model->files->baseName . '.' . $model->files->extension);
                
            }
            
            $interviewpronouns = $post['Interview']['pronouns'];
            
            if($interviewpronouns!==null&&is_array($interviewpronouns))
            foreach($interviewpronouns as $ps){
                //if is not number - user filled Pronouns
                if(!is_numeric(trim($ps))){
                    $existingPs = Pronouns::find()
                                ->where(['value' => trim($ps)])
                                ->one();
                    //double check: Pronouns aleady exists, link it to interview by adding to Interviewpron table
                    if($existingPs!=null&&$existingPs->id!=null){
                        $newIps = new Interviewpron();
                        $newIps->interviewId = $id;
                        $newIps->pronounsId = $existingPs->id;
                        $newIps->save();
                    }
                }else{
                     //is number find the Pronouns by id
                     $existingPs = Pronouns::find()
                                ->where(['id' => trim($ps)])
                                ->one(); 
                    //link it to interview by adding to Interviewpron table
                     if($existingPs!=null&&$existingPs->id!=null){
                        $newIps = new Interviewpron();
                        $newIps->interviewId = $id;
                        $newIps->pronounsId = $existingPs->id;
                        $newIps->save();
                     }
                }
            }
            $interviewsexos = $post['Interview']['sexo'];
            
            if($interviewsexos!==null&&is_array($interviewsexos))
            foreach($interviewsexos as $ss){
                //if is not number - user filled Sexual Orientation
                if(!is_numeric(trim($ss))){
                    $existingSs = SexualOrientation::find()
                                ->where(['value' => trim($ss)])
                                ->one();
                    //double check: SexualOrientation aleady exists, link it to interview by adding to Interviewsexo table
                    if($existingSs!=null&&$existingSs->id!=null){
                        $newIss = new Interviewsexo();
                        $newIss->interviewId = $id;
                        $newIss->sexoId = $existingSs->id;
                        $newIss->save();
                    }
                }else{
                     //is number find the SexualOrientation by id
                     $existingSs = SexualOrientation::find()
                                ->where(['id' => trim($ss)])
                                ->one(); 
                    //link it to interview by adding to Interviewsexo table
                     if($existingSs!=null&&$existingSs->id!=null){
                        $newIss = new Interviewsexo();
                        $newIss->interviewId = $id;
                        $newIss->sexoId = $existingSs->id;
                        $newIss->save();
                     }
                }
            }

            $interviewgenders = $post['Interview']['genders'];
            
            if($interviewgenders!==null&&is_array($interviewgenders))
            foreach($interviewgenders as $ps){
                //if is not number - user filled genders
                if(!is_numeric(trim($ps))){
                    $existingPs = Gender::find()
                                ->where(['name' => trim($ps)])  // Fixed field name
                                ->one();
                    //double check: Gender aleady exists, link it to interview by adding to Interviewgender table
                    if($existingPs!=null&&$existingPs->id!=null){
                        $newIps = new Interviewgender();
                        $newIps->interviewId = $id;
                        $newIps->genderId = $existingPs->id;
                        $newIps->save();
                    }
                }else{
                     //is number find the gender by id
                     $existingPs = Gender::find()
                                ->where(['id' => trim($ps)])
                                ->one(); 
                    //link it to interview by adding to Interviewgender table
                     if($existingPs!=null&&$existingPs->id!=null){
                        $newIps = new Interviewgender();
                        $newIps->interviewId = $id;
                        $newIps->genderId = $existingPs->id;
                        $newIps->save();
                     }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Interview model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $org_imageFile = $model->imageFile;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             #if narrator name empty set = interviewee name 
            if(!($model->narratorNameD!=null&&trim($model->narratorNameD)!='')){
                $model->narratorNameD=$model->intervieweeName;
                $model->save();
            }
            $post = Yii::$app->request->post();
            //save uploaded file if there is any
            if($model->files = UploadedFile::getInstance($model, 'files')){
                if (!is_dir('uploads/interview_'.$id)) {
                    mkdir('uploads/interview_'.$id, 0755, true);
                }
                $newfile = $model->files->baseName . '.' . $model->files->extension;
                $model->imageFile = $newfile;   
                if($newfile!=null&&trim($newfile)!='') {  
                    if($org_imageFile!=null&&trim($org_imageFile)!=''){
                        if (file_exists('uploads/interview_'.$id.'/'.$org_imageFile)){
                            unlink('uploads/interview_'.$id.'/'.$org_imageFile);
                        }
                    }
                    $model->save();
                }
                $model->files->saveAs('uploads/interview_'.$id.'/' . $model->files->baseName . '.' . $model->files->extension);
               
                
            }
            
            $interviewpronouns = $post['Interview']['pronouns'];
            //delete old Ips
             $existingIps = Interviewpron::find()
                                ->where(['interviewId' => $id])
                                ->all();
            foreach($existingIps as $ips){
                $ips->delete();
            }
            if($interviewpronouns!==null&&is_array($interviewpronouns))
            foreach($interviewpronouns as $ps){
                //if is not number - user filled Pronouns
                if(!is_numeric(trim($ps))){
                    $existingPs = Pronouns::find()
                                ->where(['value' => trim($ps)])
                                ->one();
                    //double check: Pronouns aleady exists, link it to interview by adding to Interviewpron table
                    if($existingPs!=null&&$existingPs->id!=null){
                        $newIps = new Interviewpron();
                        $newIps->interviewId = $id;
                        $newIps->pronounsId = $existingPs->id;
                        $newIps->save();
                    }
                }else{
                     //is number find the Pronouns by id
                     $existingPs = Pronouns::find()
                                ->where(['id' => trim($ps)])
                                ->one(); 
                    //link it to interview by adding to Interviewpron table
                     if($existingPs!=null&&$existingPs->id!=null){
                        $newIps = new Interviewpron();
                        $newIps->interviewId = $id;
                        $newIps->pronounsId = $existingPs->id;
                        $newIps->save();
                     }
                }
            }
            $interviewsexos = $post['Interview']['sexo'];
            //delete old Iss
             $existingIss = Interviewsexo::find()
                                ->where(['interviewId' => $id])
                                ->all();
            foreach($existingIss as $iss){
                $iss->delete();
            }
            if($interviewsexos!==null&&is_array($interviewsexos))
            foreach($interviewsexos as $ss){
                //if is not number - user filled Sexual Orientation
                if(!is_numeric(trim($ss))){
                    $existingSs = SexualOrientation::find()
                                ->where(['value' => trim($ss)])
                                ->one();
                    //double check: SexualOrientation aleady exists, link it to interview by adding to Interviewsexo table
                    if($existingSs!=null&&$existingSs->id!=null){
                        $newIss = new Interviewsexo();
                        $newIss->interviewId = $id;
                        $newIss->sexoId = $existingSs->id;
                        $newIss->save();
                    }
                }else{
                     //is number find the SexualOrientation by id
                     $existingSs = SexualOrientation::find()
                                ->where(['id' => trim($ss)])
                                ->one(); 
                    //link it to interview by adding to Interviewsexo table
                     if($existingSs!=null&&$existingSs->id!=null){
                        $newIss = new Interviewsexo();
                        $newIss->interviewId = $id;
                        $newIss->sexoId = $existingSs->id;
                        $newIss->save();
                     }
                }
            }
            $interviewgenders = $post['Interview']['genders'];
            //delete old Ips
             $existingIps = Interviewgender::find()
                                ->where(['interviewId' => $id])
                                ->all();
            foreach($existingIps as $ips){
                $ips->delete();
            }
            if($interviewgenders!==null&&is_array($interviewgenders))
            foreach($interviewgenders as $ps){
                //if is not number - user filled gender
                if(!is_numeric(trim($ps))){
                    $existingPs = Gender::find()
                                ->where(['name' => trim($ps)])  // Fixed field name
                                ->one();
                    //double check: genders aleady exists, link it to interview by adding to Interviewpron table
                    if($existingPs!=null&&$existingPs->id!=null){
                        $newIps = new Interviewgender();
                        $newIps->interviewId = $id;
                        $newIps->genderId = $existingPs->id;
                        $newIps->save();
                    }
                }else{
                     //is number find the gender by id
                     $existingPs = Gender::find()
                                ->where(['id' => trim($ps)])
                                ->one(); 
                    //link it to interview by adding to Interviewpron table
                     if($existingPs!=null&&$existingPs->id!=null){
                        $newIps = new Interviewgender();
                        $newIps->interviewId = $id;
                        $newIps->genderId = $existingPs->id;
                        $newIps->save();
                     }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Interview model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $interview = $this->findModel($id);
        //delete sexual orientation links
        $interviewSexos=$interview->interviewsexos;
        foreach($interviewSexos as $interviewSexo ){
            $interviewSexo->delete();
        }
        //delete pronoun links
        $interviewprons=$interview->interviewprons;
        foreach($interviewprons as $interviewpron ){
            $interviewpron->delete();
        }

        //delete genders links
        $interviewgenders=$interview->interviewgender;
        foreach($interviewgenders as $interviewgender ){
            $interviewgender->delete();
        }
        //delete publish media, storage and transcription
        $publishMedias = $interview->publishMedia;
        foreach($publishMedias as $publishMedia ){
            
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
        }
        // delete interview files and folder
        $this->deleteDir('uploads/interview_'.$id.'/');
        $interview->delete();

        return $this->redirect(['index']);
    }

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
     * Finds the Interview model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Interview the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Interview::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
