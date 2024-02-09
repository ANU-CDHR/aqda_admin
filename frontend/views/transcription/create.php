<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Transcription */

$this->title = 'Create Transcription';
$this->params['breadcrumbs'][] = ['label' => 'Transcriptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transcription-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
