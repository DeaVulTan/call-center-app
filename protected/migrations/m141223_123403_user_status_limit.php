<?php

class m141223_123403_user_status_limit extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	    $this->addColumn('user_status', 'limit_message', 'VARCHAR(255) NOT NULL COMMENT \'Сообщение при достижении лимита\'');
	}

	public function safeDown()
	{
        $this->dropColumn('user_status', 'limit_message');
	}
}