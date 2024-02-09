<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\SexualOrientation */

$this->title = 'Update Sexual Orientation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sexual Orientations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sexual-orientation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
