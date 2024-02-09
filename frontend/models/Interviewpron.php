<?php

namespace frontend\models;

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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['interviewId', 'pronounsId'], 'required'],
            [['interviewId', 'pronounsId'], 'integer'],
            [['interviewId', 'pronounsId'], 'unique', 'targetAttribute' => ['interviewId', 'pronounsId']],
            [['interviewId'], 'exist', 'skipOnError' => true, 'targetClass' => Interview::className(), 'targetAttribute' => ['interviewId' => 'id']],
            [['pronounsId'], 'exist', 'skipOnError' => true, 'targetClass' => Pronouns::className(), 'targetAttribute' => ['pronounsId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'interviewId' => 'Interview ID',
            'pronounsId' => 'Pronouns ID',
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
