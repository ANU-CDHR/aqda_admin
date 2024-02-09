<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);

$GuestArray = ["user/security/login","site/index","site/about","site/contact","site/privacy"];

if(Yii::$app->user->isGuest&&!in_array(trim(Yii::$app->controller->getRoute()),$GuestArray)){

    Yii::$app->response->redirect(array('user/security/login'));

}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?= \TomLutzenberger\GoogleAnalytics\GoogleAnalytics::widget([
    'gaId' => 'G-4G06KG2975'
]) ?>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
            //'label' => 'Modules',
            'items' => [
                Yii::$app->getModule('api')->dashboardNavItems(),
                
            ]
        ]);
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $isSysAdmin = \Yii::$app->user->can("SysAdmin");
     
    if (Yii::$app->user->isGuest) {
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            //['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Privacy Policy', 'url' => ['/site/privacy']],
            //['label' => 'Contact', 'url' => ['/site/contact']],
        ];
    }elseif($isSysAdmin){
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Interviews', 'url' => ['/interview/index']],
            ['label' => 'Narrators', 'url' => ['/interviewee/index']],
            ['label' => 'Interviewers', 'url' => ['/interviewer/index']],
            ['label' => 'Vocabularies', 'url' => ['/interview/settings']],
            ['label' => 'Admin', 'url' => ['/admin/index']],
            //['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Privacy Policy', 'url' => ['/site/privacy']],
            //['label' => 'Contact', 'url' => ['/site/contact']],
            
        ];
    }else{
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Interviews', 'url' => ['/interview/index']],
            ['label' => 'Narrators', 'url' => ['/interviewee/index']],
            ['label' => 'Interviewers', 'url' => ['/interviewer/index']],
            ['label' => 'Vocabularies', 'url' => ['/interview/settings']],
            //['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Privacy Policy', 'url' => ['/site/privacy']],
            //['label' => 'Contact', 'url' => ['/site/contact']],
        ];
    }
    if (Yii::$app->user->isGuest) {
        //$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/user/security/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>



