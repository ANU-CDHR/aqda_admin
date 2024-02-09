<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Interviewee */

$this->title = 'Create Narrator';
$this->params['breadcrumbs'][] = ['label' => 'Narrators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="interviewee-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
