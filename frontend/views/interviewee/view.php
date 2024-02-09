<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\models\MigrationStatus;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Interviewee */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Narrators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$publishedValue = ['0' => 'No', '1' => 'Yes'];
?>
<div class="interviewee-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php 
        $interviews = $model->interviews;
        if($interviews!=null&&sizeof($interviews)>0){
            echo Html::a('Delete', ['view','id'=>$model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'The narrator is linked to an interview. To delete the Narrator the linked interview needs to be deleted first.',
                ],
            ]);
        }else{
            echo Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        }?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'birthYear',
        ],
    ]) ?>
    <br/>
    <?php
 $content= '<div class="form-group"><div class="row"><div class="col-md-8" style="text-align:left;padding-left:10"><h3>
 Interview Records</h3></div>
 <div class="col-md-4" style="text-align:right;padding-right:10"><h3>'.
 Html::button('Reset', ['class' => 'btn btn-danger','onclick'=>'window.location="'.Url::to(['interviewee/view', 'id' => $model->id]).'"']).
 '</h3></div></div></div>';
 echo $content; ?>
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
                'format'=>'raw',
                'value' => function ($model, $key, $index, $column) 
                {
                    return $model->migrationName;
                },
                'filter'=>ArrayHelper::map(MigrationStatus::find()->orderBy('id')->asArray()->all(), 'name', 'name'),
              
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
                        return Html::a('<span class="glyphicon glyphicon-eye-open" title="View"></span>', $url, ['target' => "_blank"]);
                    },
                    'update' => function ($url, $model) {

                        return Html::a('<span class="glyphicon glyphicon-pencil" title="Update"></span>',$url,['target' => "_blank"]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash" title="Delete"></span>', $url,['data' => [
                            'confirm' => 'Are you sure you want to delete this item? All publish media, storage and transcription records will be deleted if you confirm.',
                            'method' => 'post',
                        ]]);
                    },
                ],
                'urlCreator' => function( $action, $model, $key, $index ){

                    if ($action == "update") {

                        return Url::to(['interview/update', 'id' => $model->id]);

                    }
                    if ($action == "view") {

                        return Url::to(['interview/view', 'id' => $model->id]);

                    }
                    if ($action == "delete") {

                        return Url::to(['interview/delete', 'id' => $model->id]);

                    }

                }
           ],
        ],
    ]); ?>

</div>


