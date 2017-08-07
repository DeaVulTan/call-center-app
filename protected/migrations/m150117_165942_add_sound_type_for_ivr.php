<?php

class m150117_165942_add_sound_type_for_ivr extends CDbMigration
{
	public function safeUp()
	{
		$this->addColumn('sound', 'type', 'INT(1) NOT NULL DEFAULT 0 COMMENT \'0 - стандартные звуки, 1 - звуки для IVR\'');
	}

	public function safeDown()
	{
		$this->dropColumn('sound', 'type');
	}
}