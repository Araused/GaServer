<?php

namespace app\models;

use Yii;
use app\models\Gadata;

class Chart extends Gadata
{
    private $data = [
        'CO' => [
            'type' => 'ppm',
            'data' => [],
            'lastValue' => 0,
            'labelSuffix' => 'ppm',
            'roundTo' => 0,
        ],
        'NO' => [
            'type' => 'ppm',
            'data' => [],
            'lastValue' => 0,
            'labelSuffix' => 'ppm',
            'roundTo' => 0,
        ],
        'O2' => [
            'type' => 'percent',
            'data' => [],
            'lastValue' => 0,
            'labelSuffix' => '%',
            'roundTo' => 2,
        ],
        'CO2' => [
            'type' => 'percent',
            'data' => [],
            'lastValue' => 0,
            'labelSuffix' => '%',
            'roundTo' => 2,
        ],
        'CH4' => [
            'type' => 'percent',
            'data' => [],
            'lastValue' => 0,
            'labelSuffix' => '%',
            'roundTo' => 2,
        ],
    ];

    public function getData($date = null, $gaid = null, $browserTime = null)
    {
        if ($gaid === null) {
            $gaid = self::getGaid();
        }

        $currentDate = date('Y-m-d');
        $fDate = $date === null ? $currentDate : $date;

        if ($fDate == $currentDate) {
            $condition = ['<', 'FTIME', $browserTime == null ? date('H:i:s') : $browserTime];
        } else {
            $condition = ['gaid' => $gaid];
        }

        $models = self::find()
                ->where(['FDATE' => $fDate, 'gaid' => $gaid])
                ->andWhere($condition)
                ->orderBy('FTIME')
                ->groupBy('FTIME')
                ->all();

        $data = $this->data;
        $ppms = [];
        $percents = [];

        foreach ($models as $model) {
            foreach ($this->data as $key => $value) {
                $data[$key]['data'][] = [
                    ((int) strtotime($model->FDATE . ' ' . $model->FTIME)) * 1000,
                    $model->{$key},
                ];

                switch ($this->data[$key]['type']) {
                    case 'ppm':
                        $ppms[] = $model->{$key};
                        break;
                    case 'percent':
                        $percents[] = $model->{$key};
                        break;
                }
            }
        }

        if (!empty($models)) {
            foreach ($this->data as $key => $value) {
                $data[$key]['lastValue'] = end($models)->{$key};
            }
        }

        $ticks = [];
        $tBegin = 0;
        $tEnd = 0;
        $step = Yii::$app->params['tickSize'];
        $screenSize = Yii::$app->params['xAxesInterval'];

        if (count($models) > 0) {
            $mBegin = reset($models);
            $mEnd = end($models);
            $tBegin = strtotime($mBegin->FDATE . ' ' . $mBegin->FTIME);
            $tEnd = strtotime($mEnd->FDATE . ' ' . $mEnd->FTIME);
            for ($i = $tBegin; $i <= $tEnd; $i += $step * 60) {
                $ticks[] = [
                    $i * 1000,
                    date('H:i', $i),
                ];
            }
        }

        return [
            'data' => $data,
            'ticks' => $ticks,
            'xMin' => ($tEnd - $screenSize * 60) * 1000,
            'xMax' => $tEnd * 1000,
            'ppmMax' => !empty($ppms) ? ceil((max($ppms) / 100)) * 100 : 0,
            'percentMax' => !empty($percents) ? ceil(max($percents)) + 1 : 0,
        ];
    }

    public static function createRandomData()
    {
        $timeStart = microtime(true);

        Yii::$app->db->createCommand()->truncateTable(self::tableName())->execute();
        set_time_limit(0);
        $current = time() + 60 * 60 * 24;
        $step = Yii::$app->params['tickSize'];
        for ($i = $current - 60 * 60 * 48; $i < $current; $i += $step * 60) {
            $step = Yii::$app->params['tickSize'] * rand(1, 3);
            for ($j = 100; $j <= 200; $j += 100) {
                $data = new Gadata();
                $data->FDATE = date('Y-m-d', $i);
                $data->FTIME = date('H:i:s', $i);
                $data->O2 = (rand(9 * 100, 12 * 100) + rand(9 * 100, 12 * 100)) / 100;
                $data->CO = rand(800, 1000) + rand(800, 1000);
                $data->NO = rand(400, 500) + rand(400, 500);
                $data->CO2 = (rand(7 * 100, 10 * 100) + rand(7 * 100, 10 * 100)) / 100;
                $data->CH4 = (rand(1, 5 * 1000) + rand(1, 5 * 1000)) / 10000;
                $data->GAID = $j;
                $data->save();
            }
        }

        return 'done (time: ' . round((microtime(true) - $timeStart), 3) . 's)';
    }
}
