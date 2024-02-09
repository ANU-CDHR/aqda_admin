<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PublishmediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Interview: ' . $interview->accessionName.' Publish Media ';
$this->params['breadcrumbs'][] = $this->title;
$statuses = ['0' => 'In Progresss', '1' => 'Accessed'];
$mediaTypes = ['1' => 'Video', '2' => 'Audio'];
?>
<h2><?= Html::encode($this->title) ?></h2>
<div class="publish-media-index">

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

                    if ($action == "delete") {

                        return Url::to(['publishmedia/delete', 'id' => $model->id, 'interviewId' => $interviewId]);

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


</div>
