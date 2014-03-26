<?php

class m140326_104456_add_unique_index_to_friendship extends CDbMigration
{
	public function up()
	{
        $this->execute("alter table friendship add CONSTRAINT friendship_unique_from_to_pair unique index(from_id, to_id);");
	}

	public function down()
	{
        $this->execute("alter table friendship drop index friendship_unique_from_to_pair;");
	}
}