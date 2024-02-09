<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SexualorientationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sexual Orientations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sexual-orientation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Sexual Orientation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'value',

            ['class' => 'yii\grid\ActionColumn','template' => '{view} {update} {delete}',
            'buttons' => [
                'delete' => function($url, $model){
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                        'class' => '',
                        'data' => [
                            'confirm' => 'Are you absolutely sure you want to delete this item? The existing item in the interview will also be deleted. Choose cancel to update the item in the interview first, or choose confirm to delete.',
                            'method' => 'post',
                        ],
                    ]);
                }
            ]],
        ],
    ]); ?>


</div>
