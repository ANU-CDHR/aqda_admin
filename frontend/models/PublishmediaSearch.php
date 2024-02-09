<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PublishMedia;

/**
 * PublishmediaSearch represents the model behind the search form of `frontend\models\PublishMedia`.
 */
class PublishmediaSearch extends PublishMedia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'interviewId', 'mediaType', 'size', 'length'], 'integer'],
            [['accessName', 'accessionDate', 'youtubeUrl', 'youtubeDes'], 'safe'],
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
        $query = PublishMedia::find();

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
            'status' => $this->status,
            'accessionDate' => $this->accessionDate,
            'interviewId' => $this->interviewId,
            'mediaType' => $this->mediaType,
            'size' => $this->size,
            'length' => $this->length,
        ]);

        $query->andFilterWhere(['like', 'accessName', $this->accessName])
            ->andFilterWhere(['like', 'youtubeUrl', $this->youtubeDes])
            ->andFilterWhere(['like', 'youtubeUrl', $this->youtubeUrl]);

        return $dataProvider;
    }
}
