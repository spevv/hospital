<?php

use yii\db\Migration;

class m160228_143254_create_schedule extends Migration
{
    public function up()
    {
        $this->createTable('schedule', [
            'id' => $this->primaryKey(),
            'visit' => $this->integer(1)->defaultValue(1),
            'created_at' => $this->timestamp()->defaultValue(null),
            'start_at' => $this->timestamp(),
            'finish_at' => $this->timestamp(),
            'comment' => $this->text(),
            'patient_id' => $this->integer()->notNull(),
            'doctor_id' => $this->integer()->notNull()
        ]);

        $this->insert('schedule', [
            'visit' => 1,
            'created_at' => '2016-02-28 17:01:28',
            'start_at' => '2016-02-28 17:30:00',
            'finish_at' => '2016-02-28 18:00:00',
            'comment' => '',
            'patient_id' => 1,
            'doctor_id' => 1
        ]);

        $this->insert('schedule', [
            'visit' => 1,
            'created_at' => '2016-02-28 17:02:49',
            'start_at' => '2016-02-28 19:00:00',
            'finish_at' => '2016-02-28 19:30:00',
            'comment' => '',
            'patient_id' => 1,
            'doctor_id' => 1
        ]);

    }

    public function down()
    {
        $this->dropTable('schedule');
    }
}
