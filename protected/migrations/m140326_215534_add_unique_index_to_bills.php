<?php

class m140326_215534_add_unique_index_to_bills extends CDbMigration
{
    public function up()
    {
        $this->execute("alter table bills add CONSTRAINT bills_unique_user_currency_pair unique index(user_id, currency_id);");
    }

    public function down()
    {
        $this->execute("alter table bills drop index bills_unique_user_currency_pair;");
    }
}