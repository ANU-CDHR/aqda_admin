<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TranscriptionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transcription-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'timestamp') ?>

    <?= $form->field($model, 'segmentTitle') ?>

    <?= $form->field($model, 'partialTranscription') ?>

    <?= $form->field($model, 'keywords') ?>

    <?php // echo $form->field($model, 'subject') ?>

    <?php // echo $form->field($model, 'synopsis') ?>

    <?php // echo $form->field($model, 'gps') ?>

    <?php // echo $form->field($model, 'mediaId') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
