<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pronouns".
 *
 * @property int $id
 * @property string $value
 */
class Pronouns extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pronouns';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[Interviewprons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewprons()
    {
        return $this->hasMany(Interviewpron::className(), ['pronounsId' => 'id']);
    }

    /**
     * Gets query for [[Interviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterviews()
    {
        return $this->hasMany(Interview::className(), ['id' => 'interviewId'])->viaTable('interviewpron', ['pronounsId' => 'id']);
    }
}
