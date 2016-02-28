<?php

use yii\db\Migration;

class m160226_132119_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'fullname' => $this->string()->notNull(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert('user', [
            'fullname' => 'Doctor 1',
            'username' => 'doctor1',
            'auth_key' => 'q1Ib1gsM6LKTzZyrj81topi0925T11GP',
            'password_hash' => '$2y$13$02B7Gme8PhQ8Jc1BYPf6/.YiwaafU5IDsqe5B01CJnu..Hykdf0IS',
            'password_reset_token' => null,
            'email' => 'doctor1@gmail.com',
            'status' => '10',
            'created_at' => '1456649803',
            'updated_at' => '1456649803'
        ]);

        $this->insert('user', [
            'fullname' => 'Doctor 2',
            'username' => 'doctor2',
            'auth_key' => '6P5qih8G7C8q2qJbePszpqmAFHMcmTFl',
            'password_hash' => '$2y$13$31Y3CW35tCr6IfY5FxcVVuhjlVrtXAJkeYgmXM2BlT2XNewb7hKia',
            'password_reset_token' => null,
            'email' => 'doctor2@gmail.com',
            'status' => '10',
            'created_at' => '1456671141',
            'updated_at' => '1456671141'
        ]);

        $this->insert('user', [
            'fullname' => 'Doctor 3',
            'username' => 'doctor3',
            'auth_key' => '8tYyxJtsr5bFZTixLCmSACGO4nzDYBTo',
            'password_hash' => '$2y$13$KwTp6NwDn6I4iVFcZKiTmeWAUVpSiAAG7rYKeEm93WVw1X/Aw7yvi',
            'password_reset_token' => null,
            'email' => 'doctor3@gmail.com',
            'status' => '10',
            'created_at' => '1456671252',
            'updated_at' => '1456671252'
        ]);

        $this->insert('user', [
            'fullname' => 'Oleksandr Spivak',
            'username' => 'patient1',
            'auth_key' => 'HABdQWFTgW8louCvnhRL1-Dn9SCJJO2_',
            'password_hash' => '$2y$13$Wx9bBI6.0SyDCDOlFmonj.p6wRyKDcuLsBI7oYTAl0KvvyyQJh.hS',
            'password_reset_token' => null,
            'email' => 'patient1@gmail.com',
            'status' => '10',
            'created_at' => '1456671522',
            'updated_at' => '1456671522'
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
