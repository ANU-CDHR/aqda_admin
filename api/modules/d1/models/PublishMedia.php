<?php

namespace api\modules\d1\models;

use Yii;

/**
 * This is the model class for table "pronouns".
 *
 * @property int $id
 * @property string $value
 */
class PublishMedia extends \frontend\models\PublishMedia
{
    public function fields()
    {
        $fields = parent::fields();
        return $fields;

    }

    public function extraFields()
    {
        return [
            'interview',
            'storages',
            'transcriptions'
        ];
    }


    /**
     * Gets query for [[Interview]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterview()
    {
        $published=1;
        return $this->hasOne(Interview::className(), ['id' => 'interviewId'])->andOnCondition(['interview.published' => $published]);
    }
    
}
