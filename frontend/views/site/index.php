<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Assembling Queer Displacement Archive';
?>

<div class="site-index">

    <div class="jumbotron">
        <h1></h1>

        <p class="lead">AQDA as an experimental born digital archive of oral histories about LGBTIQ+ forced displacement. This will be the first archive to capture and preserve the phenomenon of LGBTIQ+ displacement. Beyond being simply another archive about particular phenomena, this archive is a political act of survival. The Assembling Queer Displacement Archive (AQDA) is being established to counter the hegemonies that permeate the displacement narratives,  to give visibility to the experiences of LGBTIQ+ forced displacement.

<br/><br/>This database will keeps records and medadata of interviews.<br/>

Contact 
<?= Html::mailto("Renee.dixson@anu.edu.au","Renee.dixson@anu.edu.au") ?>
<br/>
<?= Html::a('Privacy Policy', ['site/privacy'],['target'=>"_blank"]) ?>
</p>

        <p><?= Html::a('Get started with Assembling Queer Displacement Archive', ['interview/index'], ['class' => 'btn btn-lg btn-success']) ?></p>
    </div>

    <!--<div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>
    <?php //echo Html::a('Validar', Yii::$app->youtube->validationGet(Yii::$app->urlManager->createAbsoluteUrl('/site/validation')) )
    ?>
    
                <p><a class="btn btn-default" href="">About&raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="">Contact &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="">FAQ &raquo;</a></p>
            </div>
        </div>

    </div>-->
</div>
