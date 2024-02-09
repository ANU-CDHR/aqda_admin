<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Storage */

$this->title = 'Interview: ' . $publishMedia->interview->accessionName.' Publish Media '.$publishMedia->id.', Create Storage';

//$this->title = 'Create Storage';
$this->params['breadcrumbs'][] = ['label' => 'Storages', 'url' => ['list','id'=>$model->id, 'mediaId'=>$publishMedia->id,'interviewId'=>$interviewId]];
$this->params['breadcrumbs'][] = $this->title;
$storageTypes = ['1' => 'Master', '2' => 'Access'];
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
                    'label' => ''.Html::encode($this->title),
                    'content' => '',
                    'active' => true,
                ],
                [
                    'label' => 'Transcriptions',
                    'url' => Url::to(['transcription/list','mediaId'=>$publishMedia->id,'interviewId'=>$interviewId]),
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
    
    <?= Html::a('Transcriptions', ['/transcription/list', 'mediaId' => $publishMedia->id,'interviewId' => $interviewId], ['class' => 'btn btn-primary']) ?>
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

<div class="storage-index">

<h1>Storages</h1>
    <?= Html::a('Back to Storage List', ['list', 'mediaId' => $mediaId,'interviewId' => $interviewId], ['class' => 'btn btn-success']) ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'accessName',
            //'storageType',
            [
                'label' => 'Storage Type',   
                'format' => 'raw',  
                'attribute' => 'storageType',      
                'value' => function ($model, $key, $index, $column) use ($storageTypes)
                {
                    return $storageTypes[$model->storageType];
                },
                'filter'=>$storageTypes
            ],
            //'format',
            'size',
            //'location',
            //'length',
            //'createTime',
            //'equipment',
            //'uncompressedSize',
            //'noOfFiles',
            //'fileName',
            //'mediaId',
            //'notes',

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


<div class="storage-create">

    <h1><?= "Create Storage" ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
