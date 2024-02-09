<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PublishmediaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="publish-media-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'accessName') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'accessionDate') ?>

    <?= $form->field($model, 'youtubeUrl') ?>

    <?php // echo $form->field($model, 'interviewId') ?>

    <?php // echo $form->field($model, 'mediaType') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'length') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
