<?php
namespace frontend\models;
use yii\behaviors\TimestampBehavior;
use Da\User\Model\User as BaseUser;
/**
* @property int $publicPermission
* @property int $status
*/
class User extends BaseUser
{
    public $interviewCount;


    public $public_email;
    /**
     * {@inheritdoc}
     *  
     */
   /* public function behaviors()
    {
        $behaviors = [
            TimestampBehavior::class,
             //add audit log
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];

        if ($this->module->enableGdprCompliance) {
            $behaviors['GDPR'] = [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'gdpr_consent_date',
                'updatedAtAttribute' => false
            ];
        }
        return $behaviors;
        /*return [
            //add audit log
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }*/
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => \Yii::t('usuario', 'Username'),
            'email' => \Yii::t('usuario', 'Email'),
            'registration_ip' => \Yii::t('usuario', 'Registration IP'),
            'unconfirmed_email' => \Yii::t('usuario', 'New email'),
            'password' => \Yii::t('usuario', 'Password'),
            'created_at' => \Yii::t('usuario', 'Registration time'),
            'confirmed_at' => \Yii::t('usuario', 'Confirmation time'),
            'last_login_at' => \Yii::t('usuario', 'Last login time'),
            'last_login_ip' => \Yii::t('usuario', 'Last login IP'),
            'password_changed_at' => \Yii::t('usuario', 'Last password change'),
            'password_age' => \Yii::t('usuario', 'Password age'),
            'interviewCount'=>'Interview Count',
        ];
    }
    /* Gets query for [[Interviews]].
    *
    * @return \yii\db\ActiveQuery
    */
    public function getInterviews()
   {    
       return $this->hasMany(Interview::className(), ['createUserId' => 'id']);
   }

   /**
     * Gets query for my [[Interviews]] count.
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewCount()
    {
        return $this->getInterviews()->count();
    }

}