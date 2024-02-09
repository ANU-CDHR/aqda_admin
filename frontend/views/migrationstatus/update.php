<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\MigrationStatus */

$this->title = 'Update Migration Status: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Migration Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="migration-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
