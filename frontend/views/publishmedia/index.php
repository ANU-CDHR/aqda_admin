<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PublishmediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Publish Media';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publish-media-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Publish Media', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'accessName',
            'status',
            'accessionDate',
            'youtubeUrl',
            //'interviewId',
            //'mediaType',
            //'size',
            //'length',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
