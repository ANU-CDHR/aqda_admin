<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "interviewsexo".
 *
 * @property int $interviewId
 * @property int $sexoId
 *
 * @property Interview $interview
 * @property SexualOrientation $sexo
 */
class Interviewsexo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interviewsexo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['interviewId', 'sexoId'], 'required'],
            [['interviewId', 'sexoId'], 'integer'],
            [['interviewId', 'sexoId'], 'unique', 'targetAttribute' => ['interviewId', 'sexoId']],
            [['interviewId'], 'exist', 'skipOnError' => true, 'targetClass' => Interview::className(), 'targetAttribute' => ['interviewId' => 'id']],
            [['sexoId'], 'exist', 'skipOnError' => true, 'targetClass' => SexualOrientation::className(), 'targetAttribute' => ['sexoId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'interviewId' => 'Interview ID',
            'sexoId' => 'Sexo ID',
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
     * Gets query for [[Sexo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSexo()
    {
        return $this->hasOne(SexualOrientation::className(), ['id' => 'sexoId']);
    }
}
