<?php

class m150225_202817_add_backup_settings extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->execute("ALTER TABLE setting CHANGE COLUMN value value TEXT NOT NULL COMMENT 'Зачение параметра'");
		$this->insert(
			'setting',
			[
				'name' => 'backup_dir',
				'category_id' => 4,
				'title' => 'Путь до папки с бекапами',
				'value' => '/var/astravox/backup'
			]
		);

		$this->insert(
			'setting',
			[
				'name' => 'backup_prefix',
				'category_id' => 4,
				'title' => 'Префикс файлов бекапа',
				'value' => 'astravox_backup_'
			]
		);

		$this->insert(
			'setting',
			[
				'name' => 'backup_date_format',
				'category_id' => 4,
				'title' => 'Формат даты в имени файла',
				'value' => 'Ymd_His'
			]
		);

		$this->insert(
			'setting',
			[
				'name' => 'backup_paths',
				'category_id' => 4,
				'title' => 'Перечень путей для бекапа (через запятую)',
				'value' => '/etc/nginx/sites/callcenter.local,/etc/php-fpm.d/www.conf,/usr/local/comet,/etc/init.d/comet,/usr/local/nginx/html/callcenter,/tmp/astravox_mysql.sql'
			]
		);

		$this->insert(
			'setting',
			[
				'name' => 'backup_mysql_cmd',
				'category_id' => 4,
				'title' => 'Команда для снятия дампа базы данных',
				'value' => 'mysqldump -uroot callcenter > /tmp/astravox_mysql.sql'
			]
		);

	}

	public function safeDown()
	{
		$this->delete('setting', "name = 'backup_dir'");
		$this->delete('setting', "name = 'backup_prefix'");
		$this->delete('setting', "name = 'backup_date_format'");
		$this->delete('setting', "name = 'backup_paths'");
		$this->delete('setting', "name = 'backup_mysql_cmd'");
		$this->execute("ALTER TABLE setting CHANGE COLUMN value value VARCHAR(255) NOT NULL COMMENT 'Зачение параметра'");
	}
}