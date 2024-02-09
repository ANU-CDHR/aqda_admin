<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "sexualOrientation".
 *
 * @property int $id
 * @property string $value
 */
class SexualOrientation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sexualOrientation';
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
     * Gets query for [[Interviewsexos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewsexos()
    {
        return $this->hasMany(Interviewsexo::className(), ['sexoId' => 'id']);
    }
}
