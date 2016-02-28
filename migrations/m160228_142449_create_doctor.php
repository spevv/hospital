<?php

use yii\db\Migration;

class m160228_142449_create_doctor extends Migration
{
    public function up()
    {
        $this->createTable('doctor', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()
        ]);

        $this->insert('doctor', [
            'user_id' => 1,
        ]);

        $this->insert('doctor', [
            'user_id' => 2,
        ]);

        $this->insert('doctor', [
            'user_id' => 3,
        ]);
    }

    public function down()
    {
        $this->dropTable('doctor');
    }
}
