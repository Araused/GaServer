<?php

use yii\db\Schema;
use yii\db\Migration;

class m151206_014702_balance_coordinates_gadataext extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%balance}}', [
            'GAID' => $this->integer()->notNull(),
            'FDATE' => $this->date()->notNull(),
            'FTIME' => $this->time()->notNull(),
            'BAL' => $this->decimal(10, 2)->notNull(),
        ]);

        $this->createTable('{{%coordinates}}', [
            'GAID' => $this->integer()->notNull(),
            'longitude' => $this->string(12)->notNull(),
            'latitude' => $this->string(12)->notNull(),
            'FDATE' => $this->date()->notNull(),
            'FTIME' => $this->time()->notNull(),
        ]);

        $this->createTable('{{%gadataext}}', [
            'GAID' => $this->integer()->notNull(),
            'KO2' => $this->integer()->notNull(),
            'KCO' => $this->integer()->notNull(),
            'KNO' => $this->integer()->notNull(),
            'K11' => $this->integer()->notNull(),
            'KCO2' => $this->integer()->notNull(),
            'KCH4' => $this->integer()->notNull(),
            'KSO2' => $this->integer()->notNull(),
            'FDATE' => $this->date()->notNull(),
            'FTIME' => $this->time()->notNull(),
        ]);

        for ($i = -2; $i < 3; $i++) {
            $date = date('Y-m-d', time() + ($i * 60 * 60 * 24));
            for ($j = 100; $j <= 200; $j += 100) {
                $this->insert('{{%balance}}', [
                    'GAID' => $j,
                    'FDATE' => $date,
                    'FTIME' => date('H:i:s'),
                    'BAL' => rand(1000, 100000) / 100,
                ]);

                $this->insert('{{%coordinates}}', [
                    'GAID' => $j,
                    'FDATE' => $date,
                    'FTIME' => date('H:i:s'),
                    'longitude' => '56.1234' . $i + 2,
                    'latitude' => '37.1234' . $i + 2,
                ]);

                $this->insert('{{%gadataext}}', [
                    'GAID' => $j,
                    'FDATE' => $date,
                    'FTIME' => date('H:i:s'),
                    'KO2' => rand(1, 9) * 100,
                    'KCO' => rand(1, 9) * 100,
                    'KNO' => rand(1, 9) * 100,
                    'K11' => rand(1, 50),
                    'KCO2' => rand(50, 80),
                    'KCH4' => rand(90, 110),
                    'KSO2' => rand(500, 520),
                ]);
            }
        }
    }

    public function safeDown()
    {
        $this->dropTable('{{%gadataext}}');
        $this->dropTable('{{%coordinates}}');
        $this->dropTable('{{%balance}}');
    }
}
