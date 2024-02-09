<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Interview */

$this->title = 'Interview: ' . $model->accessionName;
$this->params['breadcrumbs'][] = ['label' => 'Interviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="interview-update">

    <h2><?= Html::encode($this->title) ?></h2>

<?php

echo Tabs::widget([

    'items' => [

        [
            'label' => 'Interview',
            'content' => $this->render('_form', [
                'model' => $model,
            ]),
            'active' => true

        ],
        [

            'label' => 'Publish Media',
            'url' => Url::to(['publishmedia/list','interviewId'=>$model->id]),

        ]

    ],

]);

?>


    <?php // $this->render('_form', [
       // 'model' => $model,
    //]) ?>

</div>
