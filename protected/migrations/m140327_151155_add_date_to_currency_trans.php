<?php

class m140327_151155_add_date_to_currency_trans extends CDbMigration
{
	public function up()
	{
        $this->addColumn("currency_trans",'date','DATETIME NOT NULL');
	}

	public function down()
	{
		$this->dropColumn("currency_trans",'date');
	}
}