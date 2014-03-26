<?php

class m140326_192034_currency_rates extends CDbMigration
{
	public function up()
	{
        $this->createTable("currency_rates",array(
            'id' => 'pk',
            'currency' => 'VARCHAR(20) NOT NULL',
            'rate' => 'FLOAT NOT NULL')
        );
	}

	public function down()
	{
		$this->dropTable("currency_rates");
	}
}