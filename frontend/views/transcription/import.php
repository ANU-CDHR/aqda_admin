<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TranscriptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transcriptions';
$this->params['breadcrumbs'][] = $this->title;
$statuses = ['0' => 'In Progresss', '1' => 'Accessed'];
$mediaTypes = ['1' => 'Video', '2' => 'Audio'];

?>

<div class="publish-media-view">
<?php



echo Tabs::widget([

    'items' => [

        [
            'label' => 'Interview',
            'url' => Url::to(['interview/update','id'=>$interviewId]),
            'active' => false,
        ],
        [

            'label' => 'Publish Media',
            
            //'content' => '',
            //'active' => true
            'items' => [
                
                [
                    'label' => 'Storages',
                    'url' => Url::to(['storage/list','mediaId'=>$publishMedia->id,'interviewId'=>$interviewId]),
                ],
                [
                    'label' => ''.Html::encode($this->title),
                    'content' => '',
                    'active' => true,
                ],
                [
                    'label' => 'Back to Publish Media list',
                    'url' => Url::to(['publishmedia/list','interviewId'=>$interviewId]),
                ],
            ]

        ]
    ],

]);
?>

<h1>Publish Media<?= Html::encode($publishMedia->id) ?></h1>

<p>
    <?= Html::a('Update', ['publishmedia/listupdate', 'id' => $publishMedia->id,'interviewId' => $interviewId], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['publishmedia/delete', 'id' => $publishMedia->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>
    <?= Html::a('Storages', ['/storage/list', 'mediaId' => $publishMedia->id,'interviewId' => $interviewId], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Back to Publish Media list', ['/publishmedia/list', 'interviewId' => $interviewId], ['class' => 'btn btn-primary']) ?>
</p>

<?= DetailView::widget([
    'model' => $publishMedia,
    'attributes' => [
        'id',
        'accessName',
        //'status',
        [
            'label' => 'Status',   
            'format' => 'raw',  
            'attribute' => 'status',      
            'value' => function ($model, $key) use ($statuses)
            {
                return $statuses[$model->status];
            },
        ],
        'accessionDate',
        [

            'attribute'=>'youtubeUrl',

            'format'=>'raw',

            'value'=>Html::a($publishMedia->youtubeUrl, $publishMedia->youtubeUrl,['target'=>'_blank']),

        ],
        //'interviewId',
        //'mediaType',
        [
            'label' => 'Media Type',   
            'format' => 'raw',  
            'attribute' => 'mediaType',      
            'value' => function ($model, $key) use ($mediaTypes)
            {
                return $mediaTypes[$model->mediaType];
            },
        ],
        'size',
        'lengthText',
    ],
]) ?>

</div>

<div class="transcription-index">

    <h1>Transcriptions</h1>

    <p>
        <?= Html::a('Create Transcription', ['listcreate', 'mediaId' => $mediaId,'interviewId' => $interviewId], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Back to list', ['list', 'mediaId' => $mediaId,'interviewId' => $interviewId], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="transcription-import">

    <h3>Import Transcriptions</h3>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <?= $form->field($publishMedia, 'csv')->label("Upload File")->fileInput() ?>
    
    <?= Html::submitButton('Import', ['class' => 'btn btn-primary']) ?>
    
    <?php ActiveForm::end(); ?>

    </div>


</div>
