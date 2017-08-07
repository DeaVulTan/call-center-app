<?php

class m150119_223722_note_fields_add_select_type_options extends CDbMigration
{
	public function safeUp()
	{
		$this->addColumn('note_field', 'options', 'VARCHAR(255) NOT NULL COMMENT \'Дополнительные параметры для поля\'');
		$this->addColumn('note_field', 'sort', 'INT(11) NOT NULL COMMENT \'Поле для сортировки элементов\'');
		$this->alterColumn('note_field', 'field_type', 'ENUM(\'text\',\'bool\',\'select\') NOT NULL');
	}

	public function safeDown()
	{
		$this->dropColumn('note_field', 'options');
		$this->dropColumn('note_field', 'sort');
		$this->alterColumn('note_field', 'field_type', 'ENUM(\'text\',\'bool\') NOT NULL');
	}
}