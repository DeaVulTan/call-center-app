<?php

class m141222_154616_user_status_limit extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('user_status', 'limit', 'INT NULL DEFAULT 0 COMMENT \'ограничение по кол-ву пользователей в статусе\'');
	}

	public function safeDown()
	{
        $this->dropColumn('user_status', 'limit');
	}
}