<?php

namespace frontend\models;

use Yii;
use frontend\models\Pronouns;
use frontend\models\SexualOrientation;
use Da\User\Model\User;

/**
 * This is the model class for table "interview".
 *
 * @property int $id
 * @property string $intervieweeLocation
 * @property string $date
 * @property string $escapeCountry
 * @property int|null $transgender
 * @property string|null $gender
 * @property int $intervieweeId
 * @property int $interviewerId
 * @property int|null $isCitizen
 * @property int $pseudonym
 * @property int $videoDistortion
 * @property int $voiceChange
 * @property string|null $contextual
 * @property int|null $refugeeCamp
 * @property string|null $gps
 * @property int $published
 * @property int $createUserId
 * @property string|null $imageFile
 * @property string|null $copyright
 * @property string $intervieweeName
 * *@property PublishMedia[] $publishMedia 
 *
 * @property Interviewee $interviewee
 */
//#[\AllowDynamicProperties]  // Add this attribute to allow dynamic properties
class Interview extends \yii\db\ActiveRecord
{
    public $files;
    public $query;
    public $sexo;     // Keep these for form usage
    public $pronouns; 
    public $genders;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interview';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['intervieweeLocation', 'date', 'intervieweeId', 'interviewerId', 'published', 'createUserId','sexo','languageId','migrationId','lat','lng','accessionName'], 'required'],
            [['query','date','intervieweeName','interviewerName','lat','lng','sexo','userName','pronouns','genders'], 'safe'],
            [['contextual'], 'string'],
            [['transgender', 'intervieweeId', 'interviewerId', 'isCitizen', 'pseudonym', 'videoDistortion', 'voiceChange', 'refugeeCamp', 'published', 'createUserId','languageId','migrationId','genderId'], 'integer'],
            [['imageFile','accessionName', 'narratorNameD'], 'string', 'max' => 100],
            [['files'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['intervieweeLocation'], 'string', 'max' => 300],
            [['docLink'], 'string', 'max' => 500],
            [['escapeCountry'], 'string', 'max' => 30],
            [['intervieweeId'], 'exist', 'skipOnError' => true, 'targetClass' => Interviewee::className(), 'targetAttribute' => ['intervieweeId' => 'id']],
            [['interviewerId'], 'exist', 'skipOnError' => true, 'targetClass' => Interviewer::className(), 'targetAttribute' => ['interviewerId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'intervieweeLocation' => 'Narrator Location',
            'date' => 'Date of Interview',
            'languageId' => 'Interview Language',
            'languageName' => 'Interview Language',
            'escapeCountry' => 'Escape Country',
            'transgender' => 'Intersex',
            'transgenderText' => 'Intersex',
            'intervieweeId' => 'Interviewee ID',
            'interviewerId' => 'Interviewer ID',
            'isCitizen' => 'Is Citizen',
            'isCitizenText' => 'Is Citizen',
            'pseudonym' => 'Pseudonym',
            'pseudonymText' => 'Pseudonym',
            'videoDistortion' => 'Video Distortion',
            'videoDistortionText' => 'Video Distortion',
            'voiceChange' => 'Voice Change',
            'voiceChangeText' => 'Voice Change',
            'contextual' => 'Contextual',
            'refugeeCamp' => 'Refugee Camp',
            'refugeeCampText' => 'Refugee Camp',
            'geojson' => 'Geojson',
            'published' => 'Published',
            'publishedText' => 'Published',
            'createUserId' => 'Create User ID',
            'imageFile' => 'Image File',
            'accessionName' => 'Accession Name',
            'intervieweeName' => 'Narrator Name',
            'narratorNameD' => 'Narrator Name (during interview)',
            'pronouns' => 'Pronouns',
            'sexo' => 'Sexual Orientation',
            'migrationId' => 'Migration Status',
            'migrationName' => 'Migration Status',     
            'lat'=>'Latitude',
            'lng'=>'Longitude',
            'genders' => 'Gender Identity',
            'genderId'=>'Gender Identity',
            'genderName'=>'Gender Identity',
            'docLink'=>'Document Link'
        ];
    }


    /**
     * @return transgenderText
     */
    public function getTransgenderText()
    {
        $transgenders=[ 1 => 'Yes', 0 => 'No' ];
        return $transgenders[$this->transgender];
    }

     /**
     * @return isCitizenText
     */
    public function getIsCitizenText()
    {
        $isCitizens=[ 1 => 'Yes', 0 => 'No' ];
        return $isCitizens[$this->isCitizen];
    }

    /**
     * @return pseudonymText
     */
    public function getPseudonymText()
    {
        $pseudonyms=[ 1 => 'Yes', 0 => 'No' ];
        return $pseudonyms[$this->pseudonym];
    }

     /**
     * @return videoDistortionText
     */
    public function getVideoDistortionText()
    {
        $videoDistortions=[ 1 => 'Yes', 0 => 'No' ];
        return $videoDistortions[$this->videoDistortion];
    }

    /**
     * @return voiceChangeText
     */
    public function getVoiceChangeText()
    {
        $voiceChanges=[ 1 => 'Yes', 0 => 'No' ];
        return $voiceChanges[$this->voiceChange];
    }

    /**
     * @return refugeeCampText
     */
    public function getRefugeeCampText()
    {
        $refugeeCamps=[ 1 => 'Yes', 0 => 'No' ];
        return $refugeeCamps[$this->refugeeCamp];
    }

    /**
     * @return publishedText
     */
    public function getPublishedText()
    {
        if($this->published==NULL)
        $this->published=0;
        $publisheds=[ 1 => 'Yes', 0 => 'No' ];
        return $publisheds[$this->published];
    }

    /**
     * Gets query for [[Interviewee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewee()
    {
        return $this->hasOne(Interviewee::className(), ['id' => 'intervieweeId']);
    }

    /**
     * @return Interviewee Name
     */
    public function getIntervieweeName()
    {
        return $this->interviewee->name;
    }

    /**
     * Gets query for [[Interviewer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewer()
    {
        return $this->hasOne(Interviewer::className(), ['id' => 'interviewerId']);
    }

    /**
     * @return Interviewer Name
     */
    public function getInterviewerName()
    {
        return $this->interviewer->name;
    }

    /**
     * Gets query for [[Interviewprons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewprons()
    {
        return $this->hasMany(Interviewpron::className(), ['interviewId' => 'id']);
    }

    /**
     * Gets query for [[Pronouns]].
     *
     * @return \yii\db\ActiveQuery
     */
    /**public function getPronouns()
    {
        return $this->hasMany(Pronouns::className(), ['id' => 'pronounsId'])->viaTable('interviewpron', ['interviewId' => 'id']);
    }**/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPronouns()
    {
        $interviewprons =  $this->interviewprons;
        $ds = "";
        foreach($interviewprons as $interviewpron){
            if($ds!="")$ds=$ds.",";
            $ds = $ds.$interviewpron->pronouns->value;
        }
        return $ds;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function setPronouns($ds)
    {
        $this->pronouns = $ds;
    }

    /**
     * Gets query for [[Interviewsexos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewsexos()
    {
        return $this->hasMany(Interviewsexo::className(), ['interviewId' => 'id']);
    }

    /**
     * Gets query for [[Sexos]].
     *
     * @return \yii\db\ActiveQuery
     */
    /**public function getSexos()
    {
        return $this->hasMany(SexualOrientation::className(), ['id' => 'sexoId'])->viaTable('interviewsexo', ['interviewId' => 'id']);
    }**/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSexo()
    {
        $interviewsexos =  $this->interviewsexos;
        $ds = "";
        foreach($interviewsexos as $interviewsexo){
            if($ds!="")$ds=$ds.",";
            $ds = $ds.$interviewsexo->sexo->value;
        }
        return $ds;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function setSexo($ds)
    {
        $this->sexo = $ds;
    }

    /**
    * 
    * Gets query for [[Language]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getLanguage()
   {
       return $this->hasOne(Language::className(), ['id'=>'languageId']);
       
   }
   /**
    * 
    * Gets query for [[Language]] name.
    *
    * @return string
    */
   public function getLanguageName()
   {
       
       return $this->language->name;
   }

    /**
    * 
    * Gets query for [[Migration]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getMigration()
   {
       return $this->hasOne(MigrationStatus::className(), ['id'=>'migrationId']);
       
   }
   /**
    * 
    * Gets query for [[Migration]] name.
    *
    * @return string
    */
   public function getMigrationName()
   {
       
       return $this->migration->name;
   }

   /**
    * Gets query for [[Gender]].
    *
    * @return \yii\db\ActiveQuery
    */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'genderId']);
    }
    /**
    * Gets query for [[Gender]] name.
    *
    * @return string
    */
    public function getGenderName()
   {
       
       return $this->gender->name;
   }

       /**
     * Gets query for [[Interviewgenders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewgender()
    {
        return $this->hasMany(Interviewgender::className(), ['interviewId' => 'id']);
    }

    /**
     * Gets query for [[Genders]].
     *
     * @return \yii\db\ActiveQuery
     */
    /**public function getGenders()
    {
        return $this->hasMany(Pronouns::className(), ['id' => 'pronounsId'])->viaTable('interviewpron', ['interviewId' => 'id']);
    }**/

    /**
     * Gets query for [[Genders]] names.
     * @return string
     */
    public function getGenders()
    {
        $interviewgenders =  $this->interviewgender;
        $ds = "";
        foreach($interviewgenders as $in){
            if($ds!="")$ds=$ds.",";
            $ds = $ds.$in->gender->name;
        }
        return $ds;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function setGenders($ds)
    {
        $this->genders = $ds;
    }

   /** Gets query for [[PublishMedia]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getPublishMedia()
  {
      return $this->hasMany(PublishMedia::className(), ['interviewId' => 'id']);
  }

     /**
    * Gets query for [[User]].
    *
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'createUserId']);
    }

    /**
     * @return User Name
     */
    public function getUserName()
    {
        return $this->user->username;
    }

}
