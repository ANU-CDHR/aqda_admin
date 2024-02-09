<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\IntervieweeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Narrators';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="interviewee-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Narrator', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'birthYear',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;{view}&nbsp;',]
        ],
    ]); ?>


</div>
