<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Gadata;

class GadataSearch extends Gadata
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GAID', 'CO', 'NO'], 'integer'],
            [['O2', 'CO2', 'CH4'], 'number'],
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
        $query = Gadata::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'FDATE' => SORT_DESC,
                    'FTIME' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'GAID' => $this->GAID,
            'FDATE' => $this->FDATE,
            'FTIME' => $this->FTIME,
            'CO' => $this->CO,
            'O2' => $this->O2,
            'NO' => $this->NO,
            'CO2' => $this->CO2,
            'CH4' => $this->CH4,
        ]);

        return $dataProvider;
    }
}
