<?php

class m150708_220459_group_save_notes extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('group', 'timeout', 'INT NOT NULL DEFAULT \'3600\'');
        $this->addColumn('group', 'redirect_num', 'VARCHAR( 20 ) NOT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('group', 'timeout');
        $this->dropColumn('group', 'redirect_num');
    }
}