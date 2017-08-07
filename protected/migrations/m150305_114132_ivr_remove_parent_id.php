<?php

class m150305_114132_ivr_remove_parent_id extends CDbMigration
{
	public function safeUp()
	{
		$this->dropColumn('main_ivr', 'parent_id');
	}

	public function safeDown()
	{
		$this->addColumn('main_ivr', 'parent_id', 'INT(11) NOT NULL DEFAULT 0');
	}
}