<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\traits\GaidTrait;

/**
 * This is the model class for table "balance".
 *
 * @property integer $GAID
 * @property string $FDATE
 * @property string $FTIME
 * @property string $BAL
 */
class Balance extends ActiveRecord
{
    use GaidTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%balance}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GAID', 'FDATE', 'FTIME', 'BAL'], 'required'],
            [['GAID'], 'integer'],
            [['FDATE', 'FTIME'], 'safe'],
            [['BAL'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GAID' => 'Номер г/а',
            'FDATE' => 'Дата',
            'FTIME' => 'Время',
            'BAL' => 'Баланс',
        ];
    }
}
