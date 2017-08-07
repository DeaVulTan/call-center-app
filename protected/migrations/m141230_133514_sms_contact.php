<?php

class m141230_133514_sms_contact extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable(
			'sms_contact',
			[
				'id'            => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'user_id'  => 'INT NULL COMMENT \'id пользователя кому принадлежит контакт\'',
				'title'          => 'VARCHAR(64) NOT NULL COMMENT \'название контакта\'',
				'number'           => 'VARCHAR(16) NOT NULL COMMENT \'номер для отсылки смс\'',
				'description'           => 'VARCHAR(256) NOT NULL COMMENT \'описание контакта\'',
			],
			'ENGINE = InnoDB CHARSET=utf8 COMMENT = \'контакты пользователей для отправки смс\''
		);
		$this->createIndex('fk_sms_contact_user_id_idx', 'sms_contact', 'user_id');
		$this->addForeignKey(
			'fk_sms_contact_user_id',
			'sms_contact',
			'user_id',
			'user',
			'id',
			'SET NULL',
			'SET NULL'
		);
	}

	public function safeDown()
	{
		$this->dropForeignKey('fk_sms_contact_user_id', 'sms_contact');
		$this->dropIndex('fk_sms_contact_user_id_idx', 'sms_contact');
		$this->dropTable('sms_contact');
	}
}