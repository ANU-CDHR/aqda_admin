<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\helpers\Url;


$this->title = 'System Management';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="Admin-index">

<h1><?= Html::encode($this->title) ?></h1>
<br/>
<?= Html::a('User Admin', ['/user/admin'], ['target'=>'_blank','class' => 'btn btn-primary']) ?>

<?= Html::a('API Doc', '../../api/web/documentation', ['target'=>'_blank','class' => 'btn btn-primary']) ?>

<?= Html::a('API AccessToken', ['/api/access'], ['target'=>'_blank','class' => 'btn btn-primary']) ?>

<?php // Html::a('APIs List', ['/apis'], ['target'=>'_blank','class' => 'btn btn-primary']) ?>

</div>