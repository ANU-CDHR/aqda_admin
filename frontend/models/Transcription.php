<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "transcription".
 *
 * @property int $id
 * @property string $timestamp
 * @property string $segmentTitle
 * @property string $partialTranscription
 * @property string $keywords
 * @property string $subject
 * @property string $synopsis
 * @property string $gps
 * @property int $mediaId
 *
 * @property PublishMedia $media
 */
class Transcription extends \yii\db\ActiveRecord
{
    //public $timestampText='';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transcription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['timestamp','timestampText'], 'safe'],
            [['timestamp','partialTranscription', 'mediaId','timestampText'], 'required'],
            [['partialTranscription', 'synopsis'], 'string'],
            [['mediaId'], 'integer'],
            [['segmentTitle','keywords', 'subject'], 'string', 'max' => 500],
            [[ 'gps'], 'string', 'max' => 255],
            [['mediaId'], 'exist', 'skipOnError' => true, 'targetClass' => PublishMedia::className(), 'targetAttribute' => ['mediaId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'timestamp' => 'Timestamp (HH:MM:SS)',
            'timestampText' => 'Timestamp (HH:MM:SS)',
            'segmentTitle' => 'Segment Title',
            'partialTranscription' => 'Partial Transcription',
            'keywords' => 'Keywords',
            'subject' => 'Subject',
            'synopsis' => 'Synopsis',
            'gps' => 'GPS (Lat,Lng)',
            'mediaId' => 'Media ID',
        ];
    }

    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasOne(PublishMedia::className(), ['id' => 'mediaId']);
    }
}
