<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "storageformat".
 *
 * @property int $storageId
 * @property int $formatId
 *
 * @property Storage $storage
 * @property Format $format
 */
class Storageformat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'storageformat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['storageId', 'formatId'], 'required'],
            [['storageId', 'formatId'], 'integer'],
            [['storageId', 'formatId'], 'unique', 'targetAttribute' => ['storageId', 'formatId']],
            [['storageId'], 'exist', 'skipOnError' => true, 'targetClass' => Storage::className(), 'targetAttribute' => ['storageId' => 'id']],
            [['formatId'], 'exist', 'skipOnError' => true, 'targetClass' => Format::className(), 'targetAttribute' => ['formatId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'storageId' => 'Storage ID',
            'formatId' => 'Format ID',
        ];
    }

    /**
     * Gets query for [[Storage]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStorage()
    {
        return $this->hasOne(Storage::className(), ['id' => 'storageId']);
    }

    /**
     * Gets query for [[Format]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFormat()
    {
        return $this->hasOne(Format::className(), ['id' => 'formatId']);
    }
}
