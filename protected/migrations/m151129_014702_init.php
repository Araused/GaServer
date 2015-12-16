<?php

use yii\db\Schema;
use yii\db\Migration;
use app\models\Chart;

class m151129_014702_init extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%gadata}}', [
            'GAID' => $this->integer()->notNull(),
            'O2' => $this->float(),
            'CO' => $this->integer(),
            'NO' => $this->integer(),
            'CO2' => $this->float(),
            'CH4' => $this->float(),
            'FDATE' => $this->date()->notNull(),
            'FTIME' => $this->time()->notNull(),
            'P1' => $this->string(20),
            'P2' => $this->string(20),
            'P3' => $this->string(20),
            'P4' => $this->string(20),
            'P5' => $this->string(20),
        ]);
        
        echo '    > create random data ... ';
        echo Chart::createRandomData() . "\n";
    }

    public function safeDown()
    {
        $this->dropTable('{{%gadata}}');
    }
}
