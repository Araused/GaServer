<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Gadataext;

class GadataextSearch extends Gadataext
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GAID', 'KO2', 'KCO', 'KNO', 'K11', 'KCO2', 'KCH4', 'KSO2'], 'integer'],
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
        $query = Gadataext::find();

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
            'FDATE' => $this->FDATE,
            'KO2' => $this->KO2,
            'KCO' => $this->KCO,
            'KNO' => $this->KNO,
            'K11' => $this->K11,
            'KCO2' => $this->KCO2,
            'KCH4' => $this->KCH4,
            'KSO2' => $this->KSO2,
        ]);

        return $dataProvider;
    }
}
