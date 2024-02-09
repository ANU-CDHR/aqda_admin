<?php

namespace api\modules\d1\models;

use Yii;

/**
 * This is the model class for table "interviewpron".
 *
 * @property int $interviewId
 * @property int $pronounsId
 *
 * @property Interview $interview
 * @property Pronouns $pronouns
 */
class Interviewpron extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interviewpron';
    }

     /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['id','name'], 'required']
        ];
    }
    /**
     * Gets query for [[Interview]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterview()
    {
        return $this->hasOne(Interview::className(), ['id' => 'interviewId']);
    }

    /**
     * Gets query for [[Pronouns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPronouns()
    {
        return $this->hasOne(Pronouns::className(), ['id' => 'pronounsId']);
    }
}
