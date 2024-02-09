<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

use yii\bootstrap\Tabs;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\PublishMedia */

$this->title = 'Interview: ' . $model->interview->accessionName.' Publish Media '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Publish Media', 'url' => ['list','id' => $model->id, 'interviewId' => $interviewId]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$statuses = ['0' => 'In Progresss', '1' => 'Accessed'];
$mediaTypes = ['1' => 'Video', '2' => 'Audio'];
?>
<h2><?= Html::encode($this->title) ?></h2>
<div class="publish-media-view">
 
<?php
$content="
    
    <p>   <br/>
        ".Html::a('Create Publish Media', ['listcreate','interviewId'=>$interviewId], ['class' => 'btn btn-success'])."
    </p>

   ".GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'accessName',
            //'status',
            [
                'label' => 'Status',   
                'format' => 'raw',  
                'attribute' => 'status',      
                'value' => function ($model, $key, $index, $column) use ($statuses)
                {
                    return $statuses[$model->status];
                },
                'filter'=>$statuses
            ],
            'accessionDate',
            //'youtubeUrl',
            //'interviewId',
            //'mediaType',
            [
                'label' => 'Media Type',   
                'format' => 'raw',  
                'attribute' => 'mediaType',      
                'value' => function ($model, $key, $index, $column) use ($mediaTypes)
                {
                    return $mediaTypes[$model->mediaType];
                },
                'filter'=>$mediaTypes
            ],
            //'size',
            //'length',

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function( $action, $model, $key, $index )use ($interviewId){

                    if ($action == "update") {

                        return Url::to(['publishmedia/listupdate', 'id' => $model->id, 'interviewId' => $interviewId]);

                    }
                    if ($action == "view") {

                        return Url::to(['publishmedia/listview', 'id' => $model->id, 'interviewId' => $interviewId]);

                    }

                }
            ],
            
        ],
    ])."";

echo Tabs::widget([

    'items' => [

        [
            'label' => 'Interview',
            'url' => Url::to(['interview/update','id'=>$interviewId]),

        ],
        [

            'label' => 'Publish Media',
            
            'content' => $content,
            'active' => true

        ]

    ],

]);
?>



<p>
    <?= Html::a('Update', ['listupdate', 'id' => $model->id,'interviewId' => $interviewId], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>
    <?= Html::a('Storages', ['/storage/list', 'mediaId' => $model->id,'interviewId' => $interviewId], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Transcriptions', ['/transcription/list', 'mediaId' => $model->id,'interviewId' => $interviewId], ['class' => 'btn btn-primary']) ?>
</p>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'accessName',
        'lengthText',
        //'length',
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

            'value'=>Html::a($model->youtubeUrl, $model->youtubeUrl,['target'=>'_blank']),

        ],
        //'youtubeUrl',
        'youtubeDes',
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

    ],
]) ?>

</div>
