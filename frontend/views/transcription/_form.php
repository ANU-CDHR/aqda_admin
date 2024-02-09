<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\TimePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Transcription */
/* @var $form yii\widgets\ActiveForm */

//Create JS, confirm leaving page with saved
$this->registerJs(<<<JS

var saved=true;
var load = 0;
$('form :input').change(function(e){
        saved=false;
        //don't count transcription-timestamptext first load
        var id = $(this).attr("id");
        if(id=='transcription-timestamptext'&&load==0){
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

function sec2length($seconds) {
    $t = round($seconds);
    return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
}
if($model->timestamp){
    $model->timestampText = sec2length($model->timestamp);
}else{
    $model->timestampText="00:00:00";
}

?>

<div class="transcription-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success','onClick'=>"$(window).unbind('beforeunload');"]) ?>
    </div>

    <?php // $form->field($model, 'timestamp')->textInput() ?>
    <?= Html::activeLabel($model, 'timestamp',['class'=>'required']) ?>
    <?= TimePicker::widget(['model' => $model, 'attribute' => 'timestampText','value'=> $model->timestampText,'pluginOptions' => [
            'showSeconds' => true,
            'showMeridian' => false,
            'minuteStep' => 1,
            'secondStep' => 1,
        ]])  ?>
    <br/>

    <?= $form->field($model, 'segmentTitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'partialTranscription')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'synopsis')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'gps')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'mediaId')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success','onClick'=>"$(window).unbind('beforeunload');"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
