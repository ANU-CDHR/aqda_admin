<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\models\MigrationStatus;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\InterviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Interviews';
$this->params['breadcrumbs'][] = $this->title;
$publishedValue = ['0' => 'No', '1' => 'Yes'];
?>
<div class="interview-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::a('Vocabularies', ['settings'], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('Create Interview Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'accessionName',
            [
                'attribute' => 'intervieweeName',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a(Html::encode($data["intervieweeName"]),'index.php?r=interviewee/view&id='.$data["intervieweeId"]);
                }
            ],
            [
                'attribute' => 'interviewerName',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a(Html::encode($data["interviewerName"]),'index.php?r=interviewer/view&id='.$data["interviewerId"]);
                }
            ],
            //'intervieweeLocation',
            'date',
            'escapeCountry',
            [
                'attribute' => 'migrationName',
                'value' => 'migrationName',
                //'vAlign'=>'middle',
                //'width'=>'200px',
                'filterType'=>GridView::FILTER_SELECT2,
                    'filter'=> ArrayHelper::map(MigrationStatus::find()->orderBy('id')->asArray()->all(), 'name', 'name'),
                    'filterWidgetOptions'=>[
                        'pluginOptions'=>['allowClear'=>true],
                    ],
                'filterInputOptions'=>['placeholder'=>'Select status'],
                'format'=>'raw',
            ],
            [
                'label' => 'Published',   
                'format' => 'raw',  
                'attribute' => 'published',      
                'value' => function ($model, $key, $index, $column) use ($publishedValue)
                {
                    return $publishedValue[$model->published];
                },
                'filter'=>$publishedValue
            ],
            
            //'migrationStatus',
            //'transgender',
            //'gender',

            //'isCitizen',
            //'pseudonym',
            //'videoDistortion',
            //'voiceChange',
            //'contextual:ntext',
            //'refugeeCamp',
            //'gps',
            //'published',
            //'createUserId',
            //'imageFile',
            //'copyright',
            //'intervieweeName',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;{view}&nbsp;{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open" title="View"></span>', $url);
                    },
                    'update' => function ($url, $model) {

                        return Html::a('<span class="glyphicon glyphicon-pencil" title="Update"></span>',$url);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash" title="Delete"></span>', $url,['data' => [
                            'confirm' => 'Are you sure you want to delete this item? All publish media, storage and transcription records will be deleted if you confirm.',
                            'method' => 'post',
                        ]]);
                    },
                ],
           ],
        ],
    ]); ?>


</div>
