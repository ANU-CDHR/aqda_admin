<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Pronouns */

$this->title = 'Create Pronouns';
$this->params['breadcrumbs'][] = ['label' => 'Pronouns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pronouns-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
