<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\StorageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="storage-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'accessName') ?>

    <?= $form->field($model, 'storageType') ?>

    <?= $form->field($model, 'format') ?>

    <?= $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'length') ?>

    <?php // echo $form->field($model, 'createTime') ?>

    <?php // echo $form->field($model, 'equipment') ?>

    <?php // echo $form->field($model, 'uncompressedSize') ?>

    <?php // echo $form->field($model, 'noOfFiles') ?>

    <?php // echo $form->field($model, 'fileName') ?>

    <?php // echo $form->field($model, 'mediaId') ?>

    <?php // echo $form->field($model, 'notes') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
