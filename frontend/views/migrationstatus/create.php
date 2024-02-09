<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\MigrationStatus */

$this->title = 'Create Migration Status';
$this->params['breadcrumbs'][] = ['label' => 'Migration Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="migration-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
