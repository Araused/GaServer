<?php

namespace app\models\traits;

use yii\db\Query;
use app\models\Balance;
use app\models\Coordinates;
use app\models\Gadata;
use app\models\Gadataext;

trait GaidTrait {
    public static function listData($rows)
    {
        $return = [];
        foreach ($rows as $row) {
            $return[$row['GAID']] = $row['GAID'];
        }
        return $return;
    }

    public static function getGaids()
    {
        $rows = (new Query())
                ->select(['GAID'])
                ->distinct()
                ->from(parent::tableName())
                ->all();
        
        return self::listData($rows);
    }

    public static function getGaid()
    {
        $row = (new Query())
                ->select(['GAID'])
                ->from(parent::tableName())
                ->one();
        return $row['GAID'];
    }

    public static function getGaidTables()
    {
        return [
            Balance::tableName(),
            Coordinates::tableName(),
            Gadata::tableName(),
            Gadataext::tableName(),
        ];
    }

    public static function getGaidsFromAllTables()
    {
        $query = null;

        foreach (self::getGaidTables() as $table) {
            $_query = (new Query())
                    ->select(['GAID'])
                    ->distinct()
                    ->from($table);

            if ($query === null) {
                $query = $_query;
            } else {
                $query->union($_query);
            }
        }

        return self::listData($query->all());
    }
    
    public static function deleteGaidFromAllTables($gaid)
    {
        foreach (self::getGaidTables() as $table) {
            (new Query())
                    ->createCommand()
                    ->delete($table, ['GAID' => $gaid])
                    ->execute();
        }
    }
}
