<?php

namespace api\modules\d1\models;

use Yii;

/**
 * This is the model class for table "pronouns".
 *
 * @property int $id
 * @property string $value
 */
class Interviewee extends \frontend\models\Interviewee
{
    public function fields()
    {
        $fields = parent::fields();
        return $fields;

    }

    public function extraFields()
    {
        return [
            'interviews',
            
        ];
    }


    /**
     * Gets query for my [[Interviews]].
     * @param integer $status default 1 enabled
     * @return \yii\db\ActiveQuery
     */
    public function getInterviews()
    {
        $published=1;
        return $this->hasMany(Interview::className(), [ 'interviewerId'=> 'id'])->andOnCondition(['interview.published' => $published]);
    }
    
}
