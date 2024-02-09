<?php

namespace api\modules\d1\models;

use Yii;

/**
 * This is the model class for table "pronouns".
 *
 * @property int $id
 * @property string $value
 */
class Storage extends \frontend\models\Storage
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
        //$published=1;
        //return $this->hasOne(PublishMedia::className(), ['id' => 'mediaId']);
        $query = $this->getMedia();
        $query->joinWith('interview')
            ->andWhere(['interview.published' => 1]);
        return $query;
    }
    
}
