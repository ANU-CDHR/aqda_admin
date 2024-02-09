
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\InterviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vocabularies';
$this->params['breadcrumbs'][] = ['label' => 'Interviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="interview-index">

    <h1><?= Html::encode($this->title) ?></h1>
<?= Html::a('Pronouns', ['/pronouns'], ['target'=>'_blank','class' => 'btn btn-primary']) ?>

<?= Html::a('Sexual Orientation', ['/sexualorientation'], ['target'=>'_blank','class' => 'btn btn-primary']) ?>

<?= Html::a('Interview Language', ['/language'], ['target'=>'_blank','class' => 'btn btn-primary']) ?>

<?= Html::a('Migration Status', ['/migrationstatus'], ['target'=>'_blank','class' => 'btn btn-primary']) ?>

<?= Html::a('Gender', ['/gender'], ['target'=>'_blank','class' => 'btn btn-primary']) ?>

<?= Html::a('Storage - Format', ['/format'], ['target'=>'_blank','class' => 'btn btn-primary']) ?>


</div>
