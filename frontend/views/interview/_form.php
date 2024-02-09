<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datecontrol\DateControl;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


use frontend\models\Pronouns;
use frontend\models\Interviewpron;
use frontend\models\SexualOrientation;
use frontend\models\Interviewsexo;
use frontend\models\Interviewgender;
use frontend\models\Language;
use frontend\models\MigrationStatus;
use frontend\models\Gender;
/* @var $this yii\web\View */
/* @var $model frontend\models\Interview */
/* @var $form yii\widgets\ActiveForm */

//Create JS, confirm leaving page with saved
$this->registerJs(<<<JS

var saved=true;
$('form :input').change(function(){saved=false;});
$(window).on('beforeunload', function() {
    if(!saved)  return 'Leave page?';
});

JS
);

?>
<br/>

<div class="interview-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item? All publish media, storage and transcription records will be deleted if you confirm.',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success','onClick'=>"$(window).unbind('beforeunload');"]) ?>
    </div>
    <?= $form->field($model, 'accessionName')->textInput(['maxlength' => true]) ?>
    <?php // $form->field($model, 'intervieweeId')->textInput() ?>
    
    <?php 
        
        $url = \yii\helpers\Url::to(['interviewee/list']);
        $name = "";
        if($model->interviewee!=null && $model->interviewee->name!=null)
            $name = $model->interviewee->name;
        echo $form->field($model, 'intervieweeId')->textInput()->label('Narrator')->widget(Select2::classname(), [
            'name' => 'interviewee',
            'initValueText'=> $name,
            'maintainOrder' => true,
            'options' => ['placeholder' => 'Select a narrator ...'],
            'pluginOptions' => [
                'allowClear' => true,
                //'minimumInputLength' => 3,
                //'maximumInputLength' => 10,
                //'tags' => true,
                //'tokenSeparators' => [',', ' '],
                
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(interviewee) { return interviewee.text; }'),
                'templateSelection' => new JsExpression('function (interviewee) { return interviewee.text; }'),
            ]
        ]);

    ?>
    <?= "If you can't find the narrator in the search/dropdown list please " ?>
    <?= Html::a('Create Narrator', ['interviewee/create'], ['class' => 'btn btn-success','target'=>'_blank']) ?>
    <br/><br/>
    <?= $form->field($model, 'narratorNameD')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'interviewerId')->textInput() ?>

    <br/><div style="color:red"><b>Search map below to fill in Narrator Location, Latitude and Longitude. Move mark on the map to change Latitude and Longitude. <b/></div>
    <?= $this->render('_map', [
        'model' => $model,
    ]) ?>
    <br/>
    <?= $form->field($model, 'intervieweeLocation')->textInput(['maxlength' => true]) ?>
                
    <?= $form->field($model, 'lat')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'lng')->textInput(['readonly' => true]) ?>
    

    <?= $form->field($model, 'escapeCountry')->textInput(['maxlength' => true]) ?>


    <?php // $form->field($model, 'interviewLanguage')->textInput(['maxlength' => true]) ?>

    

    <?php $language=Language::find()->all();

    //use yii\helpers\ArrayHelper;
    $languageData=ArrayHelper::map($language,'id','name');

    echo $form->field($model, 'languageId')->dropDownList(
            $languageData,
            ['prompt'=>'Select...']
            );
    ?>

    

    <?php //= $form->field($model, 'migrationStatus')->dropDownList([ 'Asylum seeker' => 'Asylum seeker', 'Refugee' => 'Refugee', 'Migrant' => 'Migrant'], ['prompt' => '']) ?>

    <?php $migrationStatus=MigrationStatus::find()->all();

    //use yii\helpers\ArrayHelper;
    $migrationStatusData=ArrayHelper::map($migrationStatus,'id','name');

    echo $form->field($model, 'migrationId')->dropDownList(
            $migrationStatusData,
            ['prompt'=>'Select...']
            );
    ?>

<?php 
        $sexos = ArrayHelper::map(SexualOrientation::find()->orderBy('value')->all(),'id', 'value'); 
        $msexos = ArrayHelper::getColumn($model->interviewsexos,'sexoId'); 
        if(sizeof($msexos)==0)$tsexos=[];
        else
        $tsexos = explode(",",$model->sexo);
        $model->sexo = $msexos;
        $url = \yii\helpers\Url::to(['interview/sexolist']);
        echo $form->field($model, 'sexo')->label('Sexual Orientation')->widget(Select2::classname(), [
            //Select2::widget([
            'id' => 'interview-sexo',
            'name' => 'Interview[sexo]',
            'initValueText'=> $tsexos,
            'value'=> $msexos,
            'maintainOrder' => true,
            'options' => ['placeholder' => 'Select a sexual orientation ...', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => false,
                //'maximumInputLength' => 10,
                //'tags' => true,
                'tokenSeparators' => [','],
                
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(sexo) { return sexo.text; }'),
                'templateSelection' => new JsExpression('function (sexo) { return sexo.text; }'),
            ],
        ]);

    ?>

<?php 
        $pronouns = ArrayHelper::map(Pronouns::find()->orderBy('value')->all(),'id', 'value'); 
        $mpronouns = ArrayHelper::getColumn($model->interviewprons,'pronounsId'); 
        if(sizeof($mpronouns)==0)$tpronouns=[];
        else
        $tpronouns = explode(",",$model->pronouns);
        $model->pronouns = $mpronouns;
        $url = \yii\helpers\Url::to(['interview/pronounslist']);
        echo $form->field($model, 'pronouns')->label('Pronouns')->widget(Select2::classname(), [
            //Select2::widget([
            'id' => 'interview-pronouns',
            'name' => 'Interview[pronouns]',
            'initValueText'=> $tpronouns,
            'value'=> $mpronouns,
            'maintainOrder' => true,
            'options' => ['placeholder' => 'Select a pronouns ...', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => false,
                //'maximumInputLength' => 10,
                //'tags' => true,
                'tokenSeparators' => [','],
                
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(pronouns) { return pronouns.text; }'),
                'templateSelection' => new JsExpression('function (pronouns) { return pronouns.text; }'),
            ],
        ]);

    ?>



    <?php // $form->field($model, 'transgender')->textInput() ?>
    <?= Html::activeLabel($model,'transgender') ?>
    <?= $form->field($model, 'transgender')->checkBox(array('label'=>'', 
    'uncheckValue'=>0,'checked'=>($model->transgender==1)?true:false)) ?>

<?php 
        $genders = ArrayHelper::map(Pronouns::find()->orderBy('value')->all(),'id', 'value'); 
        $mgenders = ArrayHelper::getColumn($model->interviewgender,'genderId'); 
        if(sizeof($mgenders)==0)$tgenders=[];
        else
        $tgenders = explode(",",$model->genders);
        $model->genders = $mgenders;
        $url = \yii\helpers\Url::to(['interview/genderlist']);
        echo $form->field($model, 'genders')->label('Gender Identity')->widget(Select2::classname(), [
            //Select2::widget([
            'id' => 'interview-genders',
            'name' => 'Interview[genders]',
            'initValueText'=> $tgenders,
            'value'=> $mgenders,
            'maintainOrder' => true,
            'options' => ['placeholder' => 'Select a gender ...', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => false,
                //'maximumInputLength' => 10,
                //'tags' => true,
                'tokenSeparators' => [','],
                
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(gender) { return gender.text; }'),
                'templateSelection' => new JsExpression('function (gender) { return gender.text; }'),
            ],
        ]);

    ?>

    <?php // $form->field($model, 'gender')->dropDownList([ 'Female' => 'Female', 'Male' => 'Male', 'Non-binary' => 'Non-binary', 'Other' => 'Other', ], ['prompt' => '']) ?>

    <?php /*$genders=Gender::find()->all();

    //use yii\helpers\ArrayHelper;
    $genderData=ArrayHelper::map($genders,'id','name');

    echo $form->field($model, 'genderId')->dropDownList(
            $genderData,
            ['prompt'=>'Select...']
            );*/
    ?>


    <?php // $form->field($model, 'date')->textInput() ?>
    <?= $form->field($model, 'date')->widget(DateControl::classname(), [
        
        'displayFormat' => 'yyyy-MM-dd',
    ]) ?>
    

    <?php //= $form->field($model, 'isCitizen')->textInput() ?>
    <?= Html::activeLabel($model,'isCitizen') ?>
    <?= $form->field($model, 'isCitizen')->checkBox(array('label'=>'', 
    'uncheckValue'=>0,'checked'=>($model->isCitizen==1)?true:false)) ?>

    <?php 
        
        $url = \yii\helpers\Url::to(['interviewer/list']);
        $name = "";
        if($model->interviewer!=null && $model->interviewer->name!=null)
            $name = $model->interviewer->name;
        echo $form->field($model, 'interviewerId')->textInput()->label('Interviewer')->widget(Select2::classname(), [
            'name' => 'interviewer',
            'initValueText'=> $name,
            'maintainOrder' => true,
            'options' => ['placeholder' => 'Select a interviewer ...'],
            'pluginOptions' => [
                'allowClear' => true,
                //'minimumInputLength' => 3,
                //'maximumInputLength' => 10,
                //'tags' => true,
                //'tokenSeparators' => [',', ' '],
                
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(interviewer) { return interviewer.text; }'),
                'templateSelection' => new JsExpression('function (interviewer) { return interviewer.text; }'),
            ]
        ]);

    ?>
    <?= Html::a("If you can't find the interviewer in the list please add them here.",'index.php?r=interviewer/create', array('target'=>'_blank')); ?>
    <br/><br/>

    <?php // $form->field($model, 'pseudonym')->textInput() ?>
    <?= Html::activeLabel($model,'pseudonym') ?>
    <?= $form->field($model, 'pseudonym')->checkBox(array('label'=>'', 
    'uncheckValue'=>0,'checked'=>($model->pseudonym==1)?true:false)) ?>

    <?php //= $form->field($model, 'videoDistortion')->textInput() ?>
    <?= Html::activeLabel($model,'videoDistortion') ?>
    <?= $form->field($model, 'videoDistortion')->checkBox(array('label'=>'', 
    'uncheckValue'=>0,'checked'=>($model->videoDistortion==1)?true:false)) ?>

    <?php // $form->field($model, 'voiceChange')->textInput() ?>
    <?= Html::activeLabel($model,'voiceChange') ?>
    <?= $form->field($model, 'voiceChange')->checkBox(array('label'=>'', 
    'uncheckValue'=>0,'checked'=>($model->voiceChange==1)?true:false)) ?>

    <?= $form->field($model, 'contextual')->textarea(['rows' => 6]) ?>

    <?php // = $form->field($model, 'refugeeCamp')->textInput() ?>
    <?= Html::activeLabel($model,'refugeeCamp') ?>
    <?= $form->field($model, 'refugeeCamp')->checkBox(array('label'=>'', 
    'uncheckValue'=>0,'checked'=>($model->refugeeCamp==1)?true:false)) ?>


    

    <?php // $form->field($model, 'createUserId')->textInput() ?>

    <?php // $form->field($model, 'imageFile')->textInput() ?>
    <?php //textInput(['readonly' => true]) ?>
    <?php if($model->imageFile!=null && trim($model->imageFile)!=''){?>
    <h2 align="center">
    
    <?php // Html::img(Url::base().'/uploads/interview_'.$model->id.'/'.$model->imageFile, ['width' => '400px']) ?>
    <?= Html::img(Url::to(['showimage','id'=>$model->id]), ['width' => '400px']) ?>
    </h2>

    <?php }?>

    <?= $form->field($model, 'files')->label("Select Image File to Upload")->fileInput() ?>

    <?= $form->field($model, 'docLink')->textInput() ?>
    <?php // $form->field($model, 'intervieweeName')->textInput(['maxlength' => true]) ?>

    
   
    <?php // $form->field($model, 'published')->textInput() ?>
    <?= Html::activeLabel($model,'published') ?>

    <?php
     $isSysAdmin = \Yii::$app->user->can("SysAdmin");
     if($isSysAdmin){
    ?>
    <?php 
          echo $form->field($model, 'published')->checkBox(array('label'=>'', 
          'uncheckValue'=>0,'checked'=>($model->published==1)?true:false)); 
     }else{
        $publishedValue = ['0' => 'No', '1' => 'Yes'];
          echo '<span style="display:none">'.$form->field($model, 'published')->checkBox(array('label'=>'', 
          'uncheckValue'=>0,'checked'=>($model->published==1)?true:false)).'</span>'; 
          echo '<br/>'.$model->publishedText.'<br/><br/>';
     } 
        ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success','onClick'=>"$(window).unbind('beforeunload');"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
