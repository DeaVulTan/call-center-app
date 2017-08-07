<?php

class m150708_220459_group_save_notes extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('group', 'is_save_notes', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
        $this->addColumn('group', 'save_notes_path', 'VARCHAR(255) NOT NULL DEFAULT \'\'');
        $this->addColumn('group', 'save_notes_delimiter', 'VARCHAR(32) NOT NULL DEFAULT \'\'');
        $this->addColumn('group', 'save_notes_file_format', 'VARCHAR(100) NOT NULL DEFAULT \'\'');
    }

    public function safeDown()
    {
        $this->dropColumn('group', 'is_save_notes');
        $this->dropColumn('group', 'save_notes_path');
        $this->dropColumn('group', 'save_notes_delimiter');
        $this->dropColumn('group', 'save_notes_file_format');
    }
}