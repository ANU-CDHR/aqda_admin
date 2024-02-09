<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Transcription;

/**
 * TranscriptionSearch represents the model behind the search form of `frontend\models\Transcription`.
 */
class TranscriptionSearch extends Transcription
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'mediaId'], 'integer'],
            [['timestamp', 'segmentTitle', 'partialTranscription', 'keywords', 'subject', 'synopsis', 'gps'], 'safe'],
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
        $query = Transcription::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'timestamp' => $this->timestamp,
            'mediaId' => $this->mediaId,
        ]);

        $query->andFilterWhere(['like', 'segmentTitle', $this->segmentTitle])
            ->andFilterWhere(['like', 'partialTranscription', $this->partialTranscription])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'synopsis', $this->synopsis])
            ->andFilterWhere(['like', 'gps', $this->gps]);

        return $dataProvider;
    }
}
