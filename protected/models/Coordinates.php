<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\traits\GaidTrait;

/**
 * This is the model class for table "coordinates".
 *
 * @property integer $GAID
 * @property string $longitude
 * @property string $latitude
 * @property string $FDATE
 * @property string $FTIME
 */
class Coordinates extends ActiveRecord
{
    use GaidTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%coordinates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GAID', 'longitude', 'latitude', 'FDATE', 'FTIME'], 'required'],
            [['GAID'], 'integer'],
            [['FDATE', 'FTIME'], 'safe'],
            [['longitude', 'latitude'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GAID' => 'Номер г/а',
            'longitude' => 'Долгота',
            'latitude' => 'Широта',
            'FDATE' => 'Дата',
            'FTIME' => 'Время',
        ];
    }
}
