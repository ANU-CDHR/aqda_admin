<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "gender".
 *
 * @property int $id
 * @property string $name
 */
class Gender extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gender';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 20],
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
        ];
    }
     
   /** 
    * Gets query for [[Interviews]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getInterviews() 
   { 
       return $this->hasMany(Interview::className(), ['genderId' => 'id']); 
   } 

}
