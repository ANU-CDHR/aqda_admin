<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\Tabs;


/* @var $this yii\web\View */
/* @var $model frontend\models\Interview */

$this->title = 'Interview: ' . $model->accessionName;
$this->params['breadcrumbs'][] = ['label' => 'Interviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="interview-view">

<h2><?= Html::encode($this->title) ?></h2>

<?php

echo Tabs::widget([

    'items' => [

        [
            'label' => 'Interview',
            //'content' => $content,
            'active' => true

        ],
        [

            'label' => 'Publish Media',
            'url' => Url::to(['publishmedia/list','interviewId'=>$model->id]),

        ]

    ],

]);

?>
<br/>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item? All publish media, storage and transcription records will be deleted if you confirm.',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <!-- show image -->
    <?php if($model->imageFile!=null && trim($model->imageFile)!=''){?>
    <h2 align="center">
    <!--<?= Html::img(Yii::getAlias('@uploads').'/interview_'.$model->id.'/'.$model->imageFile, ['width' => '400px']) ?>
    -->
    <!--<?= Html::img([Url::base().'/uploads/interview_'.$model->id.'/'.$model->imageFile], ['width' => '400px']) ?>
    -->
    <?= Html::img(Url::to(['showimage','id'=>$model->id]), ['width' => '400px']) ?>
    <!--
    <?= Html::img(Url::base().Yii::getAlias('@uploads').'/interview_'.$model->id.'/'.$model->imageFile, ['width' => '400px']) ?>
    -->
    </h2>

    <?php }?>

    <?php
     $isSysAdmin = \Yii::$app->user->can("SysAdmin");
     if($isSysAdmin){
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'accessionName',
            'intervieweeName',
            'narratorNameD',
            'intervieweeLocation',
            'lat',
            'lng',
            'escapeCountry',
            //'interviewLanguage',
            'languageName',
            'interviewerName',
            'migrationName',
            'sexo',
            'pronouns',
            'transgenderText',
            //'genderName',
            'genders',
            'date',   
            //'migrationStatus',      
            //'transgender',        
            /*[
                'attribute' => 'transgender',
                'value' => $transgenders[$model->transgender]
            ],*/        
            'isCitizenText',
            'pseudonymText',
            'videoDistortionText',
            'voiceChangeText',
            'contextual:ntext',
            'refugeeCampText',
            //'gps',  
            //'createUserId',
            //'imageFile',
            //'copyright',
            //'intervieweeName',
            //'docLink',
            [
                'attribute'=>'Document Link',
                'format'=>'raw',
                'value'=>function ($model)
                {
                    $link = $model->docLink;
                    $scheme = parse_url($link, PHP_URL_SCHEME);
                    if (empty($scheme)) {
                        $link = 'http://' . ltrim($link, '/');
                    }
                    return Html::a($link, $link, ['target' => '_blank']);
                    
                   
                }
            ],
            'userName',
            /*[
                'attribute'=>'Creator User Name',
                'format'=>'raw',
                'value'=>function ($model)
                {
                    //return implode(', ', \yii\helpers\ArrayHelper::map($model->users1, 'id', 'username'));
                    $user=$model->user;
                    
                    //$userlink= Html::a($user->username, ['user/admin/update', 'id' => $user->id], ['target' => '_blank']);
                    
                    return $user->username;
                }
            ],*/
            
            'publishedText',
        ],
    ]) ?>
    <?php }else{ ?>
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'accessionName',
            'intervieweeName',
            'intervieweeLocation',
            'lat',
            'lng',
            'escapeCountry',
            //'interviewLanguage',
            'languageName',
            'interviewerName',
            'migrationName',
            'sexo',
            'pronouns',
            'transgenderText',
            //'genderName',
            'genders',
            'date',   
            //'migrationStatus',      
            //'transgender',        
            /*[
                'attribute' => 'transgender',
                'value' => $transgenders[$model->transgender]
            ],*/        
            'isCitizenText',
            'pseudonymText',
            'videoDistortionText',
            'voiceChangeText',
            'contextual:ntext',
            'refugeeCampText',
            //'gps',  
            //'createUserId',
            'imageFile',
            //'copyright',
            //'intervieweeName',
            
            'publishedText',
        ],
    ]) ?>
    <?php } ?>

</div>


