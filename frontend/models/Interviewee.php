<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "interviewee".
 *
 * @property int $id
 * @property int $name
 * @property string|null $birthYear
 */
class Interviewee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interviewee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'unique', 'targetAttribute' => ['name','birthYear']],
            [['name'], 'unique', 'targetAttribute' => ['name'],
            'when' => function ($model) {
                return empty($model->birthYear);
            }],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['birthYear'], 'safe'],
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
            'birthYear' => 'Birth Year',
        ];
    }

    /**
     * Gets query for my [[Interviews]].
     * @param int $status default 1 enabled
     * @return \yii\db\ActiveQuery
     */
    public function getInterviews()
    {
        return $this->hasMany(Interview::className(), [ 'intervieweeId'=> 'id']);
    }
}
