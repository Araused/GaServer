<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\traits\GaidTrait;

/**
 * This is the model class for table "gadata".
 *
 * @property integer $GAID
 * @property double $O2
 * @property integer $CO
 * @property integer $NO
 * @property double $CO2
 * @property double $CH4
 * @property string $FDATE
 * @property string $FTIME
 * @property string $P1
 * @property string $P2
 * @property string $P3
 * @property string $P4
 * @property string $P5
 */
class Gadata extends ActiveRecord
{
    use GaidTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gadata}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GAID', 'FDATE', 'FTIME'], 'required'],
            [['GAID', 'CO', 'NO'], 'integer'],
            [['O2', 'CO2', 'CH4'], 'number'],
            [['FDATE', 'FTIME'], 'safe'],
            [['P1', 'P2', 'P3', 'P4', 'P5'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GAID' => 'Номер г/а',
            'O2' => 'O2',
            'CO' => 'CO',
            'NO' => 'NO',
            'CO2' => 'CO2',
            'CH4' => 'CH4',
            'FDATE' => 'Дата',
            'FTIME' => 'Время',
            'P1' => 'P1',
            'P2' => 'P2',
            'P3' => 'P3',
            'P4' => 'P4',
            'P5' => 'P5',
        ];
    }
}
