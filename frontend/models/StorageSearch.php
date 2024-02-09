<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Storage;

/**
 * StorageSearch represents the model behind the search form of `frontend\models\Storage`.
 */
class StorageSearch extends Storage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'storageType', 'size', 'length', 'uncompressedSize', 'noOfFiles', 'mediaId'], 'integer'],
            [['accessName', 'format', 'location', 'equipment', 'fileName', 'notes'], 'safe'],
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
        $query = Storage::find();

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
            'storageType' => $this->storageType,
            'size' => $this->size,
            'length' => $this->length,
            'uncompressedSize' => $this->uncompressedSize,
            'noOfFiles' => $this->noOfFiles,
            'mediaId' => $this->mediaId,
        ]);

        $query->andFilterWhere(['like', 'accessName', $this->accessName])
            ->andFilterWhere(['like', 'format', $this->format])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'equipment', $this->equipment])
            ->andFilterWhere(['like', 'fileName', $this->fileName])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
