<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "storage".
 *
 * @property int $id
 * @property string $accessName
 * @property int $storageType
 * @property string $format
 * @property int $size
 * @property string $location
 * @property int $length
 * @property string $equipment
 * @property int $uncompressedSize
 * @property int $noOfFiles
 * @property string $fileName
 * @property int $mediaId
 * @property string $notes
 * @property Storageformat[] $storageformats 
 * @property Format[] $formats 
 *
 * @property PublishMedia $media
 */
class Storage extends \yii\db\ActiveRecord
{
    //public $lengthText='';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'storage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['accessName', 'storageType', 'mediaId'], 'required'],
            [['storageType', 'size', 'length', 'uncompressedSize', 'noOfFiles', 'mediaId'], 'integer'],
            [['accessName'], 'string', 'max' => 100],
            [['lengthText','format'], 'safe'],
            [['location', 'fileName', 'notes'], 'string', 'max' => 255],
            [['equipment'], 'string', 'max' => 300],
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
            'accessName' => 'Access Name',
            'storageType' => 'Storage Type',
            'format' => 'Format',
            'size' => 'Size (MB 1024MB=1GB)',
            'location' => 'Project Location',
            'length' => 'Length (HH:MM:SS)',
            'lengthText' => 'Length (HH:MM:SS)',
            'equipment' => 'Equipment',
            'uncompressedSize' => 'Uncompressed Size (MB 1024MB=1GB)',
            'noOfFiles' => 'No Of Files',
            'fileName' => 'File Name',
            'mediaId' => 'Media ID',
            'notes' => 'Notes',
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

    /** 
    * Gets query for [[Storageformats]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getStorageformats() 
   { 
       return $this->hasMany(Storageformat::className(), ['storageId' => 'id']); 
   } 
 
   /** 
    * Gets query for [[Formats]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getFormats() 
   { 
       return $this->hasMany(Format::className(), ['id' => 'formatId'])->viaTable('storageformat', ['storageId' => 'id']); 
   } 

   /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormat()
    {
        $storageformats =  $this->storageformats;
        $ds = "";
        foreach($storageformats as $storageformat){
            if($ds!="")$ds=$ds.",";
            $ds = $ds.$storageformat->format->value;
        }
        return $ds;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function setFormat($ds)
    {
        $this->format = $ds;
    }
}
