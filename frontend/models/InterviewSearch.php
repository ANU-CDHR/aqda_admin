<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Interview;
use frontend\models\MigrationStatus;
use frontend\models\Gender;

/**
 * InterviewSearch represents the model behind the search form of `frontend\models\Interview`.
 */
class InterviewSearch extends Interview
{
    public $migrationName;
    public $languageName;
    public $genderName;
    public $narratorName;
    public $intervieweeName;
    public $interviewerName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'transgender', 'intervieweeId', 'interviewerId', 'isCitizen', 'pseudonym', 'videoDistortion', 'voiceChange', 'refugeeCamp', 'published', 'createUserId'], 'integer'],
            [['intervieweeLocation', 'date', 'escapeCountry', 'migrationStatus', 'contextual', 'lat','lng', 'imageFile', 'accessionName', 'narratorName','intervieweeName','interviewerName','migrationName','languageName','genderName','narratorNameD'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Interview::find();

        // add conditions that should always apply here
        $query->joinWith('migration')->joinWith('interviewee')->joinWith('interviewer');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['migrationName'] = [
            'asc' => ['migrationStatus.name' => SORT_ASC],
            'desc' => ['migrationStatus.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['intervieweeName'] = [
            'asc' => ['interviewee.name' => SORT_ASC],
            'desc' => ['interviewee.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['interviewerName'] = [
            'asc' => ['interviewer.name' => SORT_ASC],
            'desc' => ['interviewer.name' => SORT_DESC],
        ];

        
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'transgender' => $this->transgender,
            'intervieweeId' => $this->intervieweeId,
            'interviewerId' => $this->interviewerId,
            'isCitizen' => $this->isCitizen,
            'pseudonym' => $this->pseudonym,
            'videoDistortion' => $this->videoDistortion,
            'voiceChange' => $this->voiceChange,
            'refugeeCamp' => $this->refugeeCamp,
            'published' => $this->published,
            'createUserId' => $this->createUserId,
        ]);

        $query->andFilterWhere(['like', 'intervieweeLocation', $this->intervieweeLocation])
            ->andFilterWhere(['like', 'language.name', $this->languageName])
            ->andFilterWhere(['like', 'escapeCountry', $this->escapeCountry])
            ->andFilterWhere(['like', 'migrationStatus.name', $this->migrationName])
            ->andFilterWhere(['like', 'contextual', $this->contextual])
            ->andFilterWhere(['like', 'imageFile', $this->imageFile])
            ->andFilterWhere(['like', 'accessionName', $this->accessionName])
            ->andFilterWhere(['like', 'interviewee.name', $this->intervieweeName])
            ->andFilterWhere(['like', 'interviewer.name', $this->interviewerName]);

        return $dataProvider;
    }
}
