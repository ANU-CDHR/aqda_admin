<?php

namespace api\modules\d1\models;

use Yii;

/**
 * This is the model class for table "pronouns".
 *
 * @property int $id
 * @property string $value
 */
class Transcription extends \frontend\models\Transcription
{
    public function fields()
    {
        $fields = parent::fields();
        return $fields;

    }

    public function extraFields()
    {
        return [
            'publishmedia'
            
        ];
    }
    /**
     * Gets query for [[Interviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPublishmedia()
    {
       
        $query = $this->getMedia();
        $query->joinWith('interview')
            ->andWhere(['interview.published' => 1]);
        return $query;
    }
    
}
