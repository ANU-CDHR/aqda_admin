<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Format */

$this->title = 'Create Format';
$this->params['breadcrumbs'][] = ['label' => 'Formats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="format-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
