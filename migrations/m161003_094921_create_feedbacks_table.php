<?php

use yii\db\Migration;

class m161003_094921_create_feedbacks_table extends Migration
{
    public function up()
    {
        $this->createTable('feedbacks',[
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'email' => 'string NOT NULL',
            'url' => 'string DEFAULT NULL',
            'text' => 'text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL',
            'ip' => 'string NOT NULL',
            'agent' => 'string NOT NULL',
            'date' => 'datetime NOT NULL'
        ]);
    }

    public function down()
    {
        $this->dropTable('feedbacks');
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
