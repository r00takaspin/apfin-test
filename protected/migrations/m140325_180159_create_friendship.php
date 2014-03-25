<?php

class m140325_180159_create_friendship extends CDbMigration
{
	public function up()
	{
        $this->createTable('friendship', array(
            'id' => 'pk',
            'from_id' => 'INT NOT NULL',
            'to_id' => 'INT NOT NULL',
        ));
	}

	public function down()
	{
        $this->dropTable('friendship');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}