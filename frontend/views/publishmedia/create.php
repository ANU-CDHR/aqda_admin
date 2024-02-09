<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PublishMedia */

$this->title = 'Create Publish Media';
$this->params['breadcrumbs'][] = ['label' => 'Publish Media', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publish-media-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
