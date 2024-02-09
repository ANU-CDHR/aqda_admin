<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "interviewgender".
 *
 * @property int $interviewId
 * @property int $genderId
 *
 * @property Interview $interview
 * @property Gender $gender
 */
class Interviewgender extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interviewgender';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['interviewId', 'genderId'], 'required'],
            [['interviewId', 'genderId'], 'integer'],
            [['interviewId', 'genderId'], 'unique', 'targetAttribute' => ['interviewId', 'genderId']],
            [['interviewId'], 'exist', 'skipOnError' => true, 'targetClass' => Interview::className(), 'targetAttribute' => ['interviewId' => 'id']],
            [['genderId'], 'exist', 'skipOnError' => true, 'targetClass' => Gender::className(), 'targetAttribute' => ['genderId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'interviewId' => 'Interview ID',
            'genderId' => 'Gender ID',
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
     * Gets query for [[Gender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'genderId']);
    }
}
