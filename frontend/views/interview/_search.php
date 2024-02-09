<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\InterviewSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="interview-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'intervieweeLocation') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'escapeCountry') ?>

    <?php // echo $form->field($model, 'migrationStatus') ?>

    <?php // echo $form->field($model, 'transgender') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'intervieweeId') ?>

    <?php // echo $form->field($model, 'interviewerId') ?>

    <?php // echo $form->field($model, 'isCitizen') ?>

    <?php // echo $form->field($model, 'pseudonym') ?>

    <?php // echo $form->field($model, 'videoDistortion') ?>

    <?php // echo $form->field($model, 'voiceChange') ?>

    <?php // echo $form->field($model, 'contextual') ?>

    <?php // echo $form->field($model, 'refugeeCamp') ?>

    <?php // echo $form->field($model, 'gps') ?>

    <?php // echo $form->field($model, 'published') ?>

    <?php // echo $form->field($model, 'createUserId') ?>

    <?php // echo $form->field($model, 'imageFile') ?>

    <?php // echo $form->field($model, 'copyright') ?>

    <?php // echo $form->field($model, 'intervieweeName') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
