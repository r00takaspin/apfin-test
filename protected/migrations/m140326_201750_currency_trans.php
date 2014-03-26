<?php

class m140326_201750_currency_trans extends CDbMigration
{
	public function up()
	{
        $this->createTable("currency_trans",array(
            'id'=>'pk',
            'user_id'=>'INT(10) NOT NULL',
            'from_currency_id'=>'INT(10) NOT NULL',
            'to_currency_id'=>'INT(10) NOT NULL',
            'amount'=>'FLOAT NOT NULL'
        ));
	}

	public function down()
	{
        $this->dropTable("currency_trans");
	}
}