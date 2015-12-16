<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\traits\GaidTrait;

/**
 * This is the model class for table "{{%gadataext}}".
 *
 * @property integer $GAID
 * @property integer $KO2
 * @property integer $KCO
 * @property integer $KNO
 * @property integer $K11
 * @property integer $KCO2
 * @property integer $KCH4
 * @property integer $KSO2
 * @property string $FDATE
 * @property string $FTIME
 */
class Gadataext extends ActiveRecord
{
    use GaidTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gadataext}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GAID', 'FDATE', 'FTIME'], 'required'],
            [['GAID', 'KO2', 'KCO', 'KNO', 'K11', 'KCO2', 'KCH4', 'KSO2'], 'integer'],
            [['FDATE', 'FTIME'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GAID' => 'Номер г/а',
            'KO2' => 'KO2',
            'KCO' => 'KCO',
            'KNO' => 'KNO',
            'K11' => 'K11',
            'KCO2' => 'KCO2',
            'KCH4' => 'KCH4',
            'KSO2' => 'KSO2',
            'FDATE' => 'Дата',
            'FTIME' => 'Время',
        ];
    }
}
