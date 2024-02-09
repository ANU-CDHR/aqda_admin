<?php
namespace common\models;
use \yii\db\ActiveRecord;


use api\modules\d1\models\Interviewee;
use api\modules\d1\models\Narrator;
use api\modules\d1\models\MirgationStatus;
/**
 * Country Model
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class Interview extends ActiveRecord
{
    public $migrationName;
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'interview';
	}

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
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
     * Gets query for [[Narrator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNarrator()
    {
        return $this->hasOne(Interviewee::className(), ['id' => 'intervieweeId']);
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
    * 
    * Gets query for [[Migration]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getMigration()
   {
       return $this->hasOne(MigrationStatus::className(), ['id'=>'migrationId']);
       
   }

   public function getMigrationName()
   {
       
       return $this->migration->name;
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
    * Gets query for [[Gender]].
    *
    * @return \yii\db\ActiveQuery
    */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'genderId']);
    }


    /** Gets query for [[PublishMedia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPublishMedia()
    {
        return $this->hasMany(PublishMedia::className(), ['interviewId' => 'id']);
    }

    public function fields()
    {
        $fields = parent::fields();
        //unset($fields['created_at'], $fields['updated_at'], $fields['owner_id']);
        return $fields;

        /*
            // or could also be:
            return ['id', 'name','url'];
        */
    }

    public function extraFields()
    {
        return [
            'interviewee',
            'narrator',
            'interviewer',
            'migration',
            'pronouns',
            'sexo',
            'publishMedia',
            'publishMedia.transcriptions'/* => function() {
                return $this->getInterviewees();
            },*/
        ];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['id', 'accessionName'], 'required']
        ];
    }

}
