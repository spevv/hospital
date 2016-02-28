<?php

use yii\db\Migration;

class m160228_142916_create_permission_doctor extends Migration
{
    public function up()
    {
        $this->createTable('permission_doctor', [
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer()->notNull(),
            'destination_id' => $this->integer()->notNull()
        ]);

        $this->insert('permission_doctor', [
            'owner_id' => 1,
            'destination_id' => 2,
        ]);
    }

    public function down()
    {
        $this->dropTable('permission_doctor');
    }
}
