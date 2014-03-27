<?php

class m140327_215545_add_converted_amount_to_currency_trans extends CDbMigration
{
	public function up()
	{
        $this->addColumn("currency_trans",'converted_amount','FLOAT NOT NULL');
	}

	public function down()
	{
		$this->dropColumn("currency_trans",'converted_amount');
	}
}