<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "publishMedia".
 *
 * @property int $id
 * @property string $accessName
 * @property int $status
 * @property string $accessionDate
 * @property string $youtubeUrl
 * @property int $interviewId
 * @property int $mediaType
 * @property int $size
 * @property int $length
 *
 * @property Interview $interview
 * @property Storage[] $storages
 */
class PublishMedia extends \yii\db\ActiveRecord
{
    //public $lengthText='';
    public $files;
    public $csv;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'publishMedia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['accessName', 'interviewId', 'status', 'mediaType'], 'required'],
            [['status', 'interviewId', 'mediaType', 'size', 'length'], 'integer'],
            [['accessionDate','YoutubeDes','lengthText'], 'safe'],
            [['files'], 'file', 'skipOnEmpty' => true, 'extensions' => 'mp4, mov'],
            [['csv'], 'file', 'skipOnEmpty' => true, 'extensions' => 'csv'],
            [['accessName'], 'string', 'max' => 100],
            [['youtubeUrl'], 'string', 'max' => 255],
            [['youtubeDes'], 'string', 'max' => 500],
            [['interviewId'], 'exist', 'skipOnError' => true, 'targetClass' => Interview::className(), 'targetAttribute' => ['interviewId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'accessName' => 'Accession Name',
            'status' => 'Status',
            'accessionDate' => 'Accession Date',
            'youtubeUrl' => 'Url',
            'youtubeDes' => 'Description',
            'interviewId' => 'Interview ID',
            'mediaType' => 'Media Type',
            'size' => 'Size (MB 1024MB=1GB)',
            'length' => 'Length (HH:MM:SS)',
            'lengthText' => 'Length (HH:MM:SS)',
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
     * Gets query for [[Storages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStorages()
    {
        return $this->hasMany(Storage::className(), ['mediaId' => 'id']);
    }

    /** 
    * Gets query for [[Transcriptions]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getTranscriptions() 
    { 
        return $this->hasMany(Transcription::className(), ['mediaId' => 'id']); 
    } 
    
}
