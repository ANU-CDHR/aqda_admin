<?php

namespace api\modules\d1\models;

use Yii;

/**
 * This is the model class for table "pronouns".
 *
 * @property int $id
 * @property string $value
 */
class Pronoun extends \frontend\models\Pronouns
{
    public function fields()
    {
        $fields = parent::fields();
        return $fields;

    }

    public function extraFields()
    {
        return [
            'interviews'
            
        ];
    }
    /**
     * Gets query for [[Interviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterviews()
    {
        $published=1;
        return $this->hasMany(Interview::className(), ['id' => 'interviewId'])->viaTable('interviewpron', ['pronounsId' => 'id'])->andOnCondition(['interview.published' => $published]);
    }
    
}
