<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "interviewer".
 *
 * @property int $id
 * @property string $name
 * @property string|null $bio
 */
class Interviewer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interviewer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'unique', 'targetAttribute' => ['name']],
            [['name'], 'required'],
            [['bio'], 'string'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'bio' => 'Bio',
        ];
    }

    /**
     * Gets query for my [[Interviews]].
     * @param int $status default 1 enabled
     * @return \yii\db\ActiveQuery
     */
    public function getInterviews()
    {
        return $this->hasMany(Interview::className(), [ 'interviewerId'=> 'id']);
    }

    /**
     * Gets query for my [[Interviews]].
     * @param int $status default 1 enabled
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewSearch()
    {
        return $this->hasMany(InterviewSearch::className(), [ 'interviewerId'=> 'id']);
    }
}
