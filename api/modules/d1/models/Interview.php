<?php
namespace api\modules\d1\models;
use \yii\db\ActiveRecord;


use api\modules\d1\models\Interviewee;
use api\modules\d1\models\Narrator;
use api\modules\d1\models\MirgationStatus;
/**
 * Country Model
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class Interview extends \frontend\models\Interview
{
    //public $migrationName;
	
    /**
     * Gets query for [[Narrator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNarrator()
    {
        return $this->hasOne(Interviewee::className(), ['id' => 'intervieweeId']);
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['genderId'], $fields['createUserId'],$fields['imageFile']);
        $image = ['image'=>function ($model) {
            return '/aqda/frontend/web/index.php?r=interview/showimage&id='.$model->id;
        }];
        $fields=array_merge($fields,$image);
        return $fields;

        /*
            // or could also be:
            return ['id', 'name','url'];
        */
    }

    public function extraFields()
    {
        return [
            'interviewee',
            'narrator',
            'interviewer',
            'migration',
            'language',
            'pronouns',
            'sexo',
            'genders',
            'publishMedia',
            'publishMedia.transcriptions',
            'publishMedia.storages'
            /* => function() {
                return $this->getInterviewees();
            },*/
        ];
    }

    /** Gets query for [[PublishMedia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPublishMedia()
    {
        return $this->hasMany(PublishMedia::className(), ['interviewId' => 'id']);
    }
    

}
