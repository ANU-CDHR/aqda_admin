<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TranscriptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Interview: ' . $publishMedia->interview->accessionName.' Publish Media '.$publishMedia->id.', Transcriptions ';
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
    <?= Html::a('Delete All Transcriptions', ['deleteall', 'mediaId' => $mediaId,'interviewId' => $interviewId], ['class' => 'btn btn-danger','data' => [
                'confirm' => 'Are you sure you want to delete all transcriptions? This action cannot be reversed.',
                'method' => 'post',
            ]]) ?>
        <?= Html::a('Create Transcription', ['listcreate', 'mediaId' => $mediaId,'interviewId' => $interviewId], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import Transcriptions', ['import', 'mediaId' => $mediaId,'interviewId' => $interviewId], ['class' => 'btn btn-success']) ?>

    </p>

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
