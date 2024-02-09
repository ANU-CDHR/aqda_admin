<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\SexualOrientation */

$this->title = 'Create Sexual Orientation';
$this->params['breadcrumbs'][] = ['label' => 'Sexual Orientations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sexual-orientation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
