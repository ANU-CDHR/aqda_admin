<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Interviewer */

$this->title = 'Create Interviewer';
$this->params['breadcrumbs'][] = ['label' => 'Interviewers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="interviewer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
