<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Transcription */

$this->title = 'Interview: ' . $publishMedia->interview->accessionName.' Publish Media '.$publishMedia->id.', Create Transcription ';
$this->params['breadcrumbs'][] = ['label' => 'Transcriptions', 'url' => ['list','mediaId'=>$publishMedia->id,'interviewId'=>$interviewId]];
$this->params['breadcrumbs'][] = $this->title;
$statuses = ['0' => 'In Progresss', '1' => 'Accessed'];
$mediaTypes = ['1' => 'Video', '2' => 'Audio'];
?>
<h2><?= Html::encode($this->title) ?></h2>

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

<br/>
<p>
    <?= Html::a('Update Publish Media', ['publishmedia/listupdate', 'id' => $publishMedia->id,'interviewId' => $interviewId], ['class' => 'btn btn-primary']) ?>
    
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
        'youtubeUrl',
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

    <?= Html::a('Back to Transcription List', ['list', 'mediaId' => $mediaId,'interviewId' => $interviewId], ['class' => 'btn btn-success']) ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'timestampText',
            'segmentTitle',
            //'partialTranscription:ntext',
            //'keywords',

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function( $action, $model, $key, $index )use ($interviewId,$publishMedia){

                    if ($action == "update") {

                        return Url::to(['listupdate', 'id' => $model->id, 'mediaId' => $publishMedia->id,  'interviewId' => $interviewId]);

                    }
                    if ($action == "view") {

                        return Url::to(['listview', 'id' => $model->id, 'mediaId' => $publishMedia->id, 'interviewId' => $interviewId]);

                    }
                    if ($action == "delete") {

                        return Url::to(['delete', 'id' => $model->id]);

                    }


                }
            ],
        ],
    ]); ?>


</div>


<div class="transcription-create">

    <h1>Create Transcription</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
