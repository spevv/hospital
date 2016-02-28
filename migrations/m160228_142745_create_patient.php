<?php

use yii\db\Migration;

class m160228_142745_create_patient extends Migration
{
    public function up()
    {
        $this->createTable('patient', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'doctor_id' => $this->integer()->notNull()
        ]);

        $this->insert('patient', [
            'user_id' => 4,
            'doctor_id' => 1,
        ]);
    }

    public function down()
    {
        $this->dropTable('patient');
    }
}
