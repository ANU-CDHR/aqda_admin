<?php 
// events.php file

use Da\User\Controller\AdminController;
use Da\User\Controller\SettingsController;
use Da\User\Event\UserEvent;
use Da\User\Event\GdprEvent;
use Da\User\Model\User;


//use frontend\models\User;
use yii\base\Event;
use yii\web\ForbiddenHttpException;

// This will happen at the controller's level
/*Event::on(AdminController::class, UserEvent::EVENT_AFTER_CREATE, function (UserEvent $event) {
    $user = $event->getUser();

    // ... your logic here
});*/

// This will happen at the model's level
Event::on(User::class, UserEvent::EVENT_AFTER_CREATE, function (UserEvent $event) {

    $user = $event->getUser();
    $auth = Yii::$app->authManager;
    $defaultRole = $auth->getRole("SysEditor");
    $auth->assign($defaultRole, $user->id);

    // ... your logic here
});

Event::on(AdminController::class, UserEvent::EVENT_BEFORE_DELETE, function (UserEvent $event) {
    $user = $event->getUser();
    //check map hist
    $interviewCount=$user->getInterviewCount();
    
    if($interviewCount>0){
        $message="This user can't be deleted, there are linked interviews, if you are system admin and confirm the delete, please impersonate this user, and to confirm/delete from user/settings.";
        throw new ForbiddenHttpException($message);
    }
    //remove roles
    
    $auth = Yii::$app->authManager;
    $defaultRole = $auth->getRole("SysEditor");
    $auth->revoke($defaultRole,$user->id);
    $auth->revokeAll($user->id);


    

});

Event::on(SettingsController::class, UserEvent::EVENT_BEFORE_DELETE, function (GdprEvent $event) {

  
});

