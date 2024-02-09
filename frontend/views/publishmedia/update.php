<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PublishMedia */

$this->title = 'Update Publish Media: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Publish Media', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="publish-media-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
