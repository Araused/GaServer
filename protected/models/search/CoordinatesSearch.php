<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Coordinates;

class CoordinatesSearch extends Coordinates
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GAID'], 'integer'],
            [['longitude', 'latitude'], 'string'],
            [['FDATE'], 'date', 'format' => 'php:Y-m-d'],
            [['FTIME'], 'date', 'format' => 'php:H:i:s'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Coordinates::find()
                ->select(['GAID', 'FDATE' => 'max(FDATE)', 'longitude', 'latitude'])
                ->groupBy('GAID');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'FDATE' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'GAID' => $this->GAID,
        ]);

        return $dataProvider;
    }
}
