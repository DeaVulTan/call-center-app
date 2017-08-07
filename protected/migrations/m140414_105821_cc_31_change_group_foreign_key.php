<?php

class m140414_105821_cc_31_change_group_foreign_key extends CDbMigration
{
	public function up()
	{
        $this->update('group', array('music_file_id'=> null));
        $this->dropForeignKey('fk_group_music_file', 'group');
	}

	public function down()
	{
	}
}