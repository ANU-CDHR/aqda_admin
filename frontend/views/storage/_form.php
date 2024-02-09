<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
#use kartikorm\ActiveForm;
use kartik\widgets\TimePicker;

use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use frontend\models\Format;
use frontend\models\Storageformat;

/* @var $this yii\web\View */
/* @var $model frontend\models\Storage */
/* @var $form yii\widgets\ActiveForm */

//Create JS, confirm leaving page with saved
$this->registerJs(<<<JS

var saved=true;
var load = 0;
$('form :input').change(function(e){
        saved=false;
        //don't count storage-lengthtext first load
        var id = $(this).attr("id");
        if(id=='storage-lengthtext'&&load==0){
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
if($model->length){
    $model->lengthText = sec2length($model->length);
}else{
    $model->lengthText="00:00:00";
}
?>

<div class="storage-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success','onClick'=>"$(window).unbind('beforeunload');"]) ?>
    </div>

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

    <?php // $form->field($model, 'storageType')->textInput() ?>

    <?=  $form->field($model, 'storageType')->dropDownList(
            ['1' => 'Master', '2' => 'Access']) ?>

    <?php // $form->field($model, 'format')->textInput(['maxlength' => true]) ?>

    <?php 
        $formats = ArrayHelper::map(Format::find()->orderBy('value')->all(),'id', 'value'); 
        $mformats = ArrayHelper::getColumn($model->storageformats,'formatId'); 
        if(sizeof($mformats)==0)$tformats=[];
        else
        $tformats = explode(",",$model->format);
        $model->format = $mformats;
        $url = \yii\helpers\Url::to(['storage/formatlist']);
        echo $form->field($model, 'format')->label('Format')->widget(Select2::classname(), [
            'id' => 'storage-format',
            'name' => 'Storage[format]',
            'initValueText'=> $tformats,
            'value'=> $mformats,
            'maintainOrder' => true,
            'options' => ['placeholder' => 'Select a format ...', 'multiple' => true],
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
                'templateResult' => new JsExpression('function(format) { return format.text; }'),
                'templateSelection' => new JsExpression('function (format) { return format.text; }'),
            ],
        ]);

    ?>

    <?= $form->field($model, 'size')->textInput() ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    

    <?= $form->field($model, 'equipment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uncompressedSize')->textInput() ?>

    <?= $form->field($model, 'noOfFiles')->textInput() ?>

    <?= $form->field($model, 'fileName')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'mediaId')->textInput() ?>

    <?= $form->field($model, 'notes')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success','onClick'=>"$(window).unbind('beforeunload');"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
