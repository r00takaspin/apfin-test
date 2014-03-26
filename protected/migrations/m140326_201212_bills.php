<?php

class m140326_201212_bills extends CDbMigration
{
	public function up()
	{
        $this->createTable("bills",array(
            'id'=>'pk',
            'user_id'=>'INT(10) NOT NULL',
            'currency_id'=>'INT(10) NOT NULL',
            'amount'=>'FLOAT NOT NULL',

        ));
	}

	public function down()
	{
		$this->dropTable("bills");
	}
}