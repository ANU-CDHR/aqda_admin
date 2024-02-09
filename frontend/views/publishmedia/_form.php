<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\TimePicker;
use yii\helpers\Url;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model frontend\models\PublishMedia */
/* @var $form yii\widgets\ActiveForm */

//Create JS, confirm leaving page with saved
$this->registerJs(<<<JS

var saved=true;
var load = 0;
$('form :input').change(function(e){
        saved=false;
        //don't count publishmedia-lengthtext first load
        var id = $(this).attr("id");
        if(id=='publishmedia-lengthtext'&&load==0){
            saved=true;
            load=1;
        }  
    }
);
$(window).on('beforeunload', function() {
    if(!saved)  return 'Leave page?';
});

JS
);
//trainsfer seconds to HH:MM:SS, 
function sec2length($seconds) {
    $t = round($seconds);
    return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
}
if($model->length){
    $model->lengthText = sec2length($model->length);
}else{
    $model->lengthText="00:00:00";
}

?>

<div class="publish-media-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?php if($view=="update"){ ?>
        <?= Html::a('Storages', ['/storage/list', 'mediaId' => $model->id,'interviewId' => $interviewId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Transcriptions', ['/transcription/list', 'mediaId' => $model->id,'interviewId' => $interviewId], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success','onClick'=>"$(window).unbind('beforeunload');"]) ?>
    </div>

    <?php echo Html::a(Html::img(Url::base().'/images/btn_google_signin_light_normal_web.png'), Yii::$app->youtube->validationGet(Yii::$app->urlManager->createAbsoluteUrl(['/site/validation', 'id' => $model->id,'interviewId' => $interviewId])) );
    // test on localhost first /echo Html::a('Youtube Validate', Yii::$app->youtube->validationGet("http://localhost/localpath/index.php?r=site/validation&id=".$model->id."&interviewId=".$interviewId) );
    ?>

    <?= $form->field($model, 'accessName')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'length')->textInput() ?>
    <?= Html::activeLabel($model, 'length') ?>
    <?= TimePicker::widget(['model' => $model, 'attribute' => 'lengthText','value'=> $model->lengthText,'pluginOptions' => [
            'showSeconds' => true,
            'showMeridian' => false,
            'minuteStep' => 1,
            'secondStep' => 1,
        ]])  ?>
    <br/>

    <?php // $form->field($model, 'status')->textInput() ?>

    <?=  $form->field($model, 'status')->dropDownList(
            ['0' => 'In Progresss', '1' => 'Accessed']) ?>

    <?php // $form->field($model, 'accessionDate')->textInput() ?>
    <?= $form->field($model, 'accessionDate')->widget(DateControl::classname(), [
        
        'displayFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?php // $form->field($model, 'youtubeUrl')->label(Html::img(Url::base().'/images/yt_logo_mono_light.png',['width' => '80px']).'  Url')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'youtubeUrl')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'youtubeDes')->label(Html::img(Url::base().'/images/yt_logo_mono_light.png',['width' => '80px']).'  Description')->textArea(['maxlength' => true]) ?>
    <?= $form->field($model, 'youtubeDes')->textArea(['maxlength' => true]) ?>

    <?php // $form->field($model, 'files')->label('Select Video File For  '.Html::img(Url::base().'/images/yt_logo_mono_light.png',['width' => '80px']))->fileInput() ?>
    <?= $form->field($model, 'files')->label('Select Video File ')->fileInput() ?>

    <?php //echo Html::a('Upload', ['/publishmedia/uploadvideo'] )
    ?>

    <?php // $form->field($model, 'interviewId')->textInput() ?>

    <?php // $form->field($model, 'mediaType')->textInput() ?>
    <?= $form->field($model, 'mediaType')->dropDownList(
            ['1' => 'Video', '2' => 'Audio']) ?>

    <?= $form->field($model, 'size')->textInput() ?>

   

    <div class="form-group">
        <?php if($view=="update"){ ?>
        <?= Html::a('Delete', ['publishmedia/delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
        ]) ?>
        <?= Html::a('Storages', ['/storage/list', 'mediaId' => $model->id,'interviewId' => $interviewId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Transcriptions', ['/transcription/list', 'mediaId' => $model->id,'interviewId' => $interviewId], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success','onClick'=>"$(window).unbind('beforeunload');"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
