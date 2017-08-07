<?php

class m131209_193020_cc_30_migration extends CDbMigration
{
	public function safeUp()
	{
        $this->createTable(
            'status_log',
            [
                'id'          => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'status_name' => 'VARCHAR(255) NOT NULL COMMENT \'Название статуса\'',
                'status_id'   => 'INT COMMENT \'id статуса\'',
                'user_name'   => 'VARCHAR(200) NOT NULL COMMENT \'ФИО оператора\'',
                'user_id'     => 'INT COMMENT \'id оператора\'',
                'date_start'  => 'TIMESTAMP NULL COMMENT \'Время вхождения в статус\'',
                'date_end'    => 'TIMESTAMP NULL COMMENT \'Время выхода из статуса\'',
                'status'      => 'TINYINT(1) NULL DEFAULT 1 COMMENT \'Флаг текущего статуса\'',
            ],
            'ENGINE = InnoDB COMMENT = \'Таблица для логирования смены статусов у пользователей\''
        );

        $this->createTable(
            'setting',
            [
                'id'          => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'category_id' => 'INT COMMENT \'Категории хардкодятся в коде\'',
                'name'        => 'VARCHAR(255) NOT NULL COMMENT \'Системное название параметка\'',
                'title'       => 'VARCHAR(255) NOT NULL COMMENT \'Название параметка\'',
                'value'       => 'VARCHAR(255) NOT NULL COMMENT \'Зачение параметра\'',
            ],
            'ENGINE = InnoDB COMMENT = \'Таблица для хранения настроек системы\''
        );
        $this->createIndex('fk_setting_name_idx', 'setting', 'name');

        $this->insert(
            'setting',
            ['name' => 'sms_gateway_ip', 'category_id' => 1, 'title' => 'Адрес SMS-шлюза', 'value' => '']
        );
        $this->insert(
            'setting',
            ['name' => 'sms_gateway_port', 'category_id' => 1, 'title' => 'Порт SMS-шлюза', 'value' => '']
        );
        $this->insert(
            'setting',
            ['name' => 'sms_sender_default', 'category_id' => 1, 'title' => 'Отправитель по умолчанию', 'value' => '']
        );
        $this->insert(
            'setting',
            ['name' => 'sms_sender_prefix_text', 'category_id' => 1, 'title' => 'Префикс если отправитель указан текстом', 'value' => '']
        );
        $this->insert(
            'setting',
            ['name' => 'sms_sender_prefix_phone', 'category_id' => 1, 'title' => 'Префикс если отправитель указан номером', 'value' => '']
        );
        $this->insert(
            'setting',
            ['name' => 'sms_prefix_phone', 'category_id' => 1, 'title' => 'Префикс номера направления', 'value' => '']
        );

        $this->createTable(
            'sms',
            [
                'id'         => 'BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'created_at' => 'TIMESTAMP NULL COMMENT \'Системное название параметка\'',
                'sender'     => 'VARCHAR(255) NOT NULL COMMENT \'Подпись отправителя, от кого смс\'',
                'phone'      => 'VARCHAR(45) NOT NULL COMMENT \'Номер, на который отправляется смс\'',
                'body'       => 'VARCHAR(255) NOT NULL COMMENT \'Текст смс\'',
                'status'     => 'TINYINT(1) NULL DEFAULT 0 COMMENT \'0-не отправлено, 1-отправлено\'',
                'user_id'    => 'INT COMMENT \'Идентификатор отправителя\'',
                'linkedid'   => 'VARCHAR(255)',
                'group_id'   => 'INT',
                'send_time'  => 'DATETIME NULL DEFAULT NULL',
            ],
            'ENGINE = InnoDB COMMENT = \'Таблица для отправки СМС сообщений\''
        );

        $this->addColumn('group', 'is_sms_auto_send', 'TINYINT(1) NULL DEFAULT 0 COMMENT \'Отправить СМС после разговора\'');
        $this->addColumn('group', 'is_sms_send_period', 'TINYINT(1) NULL DEFAULT 0 COMMENT \'Период отправки СМС - Селект 0-Не используется, 1-Час, 2-День, 3-Неделя, 4-Месяц\'');
        $this->addColumn('group', 'sms_sender', 'VARCHAR(100) NULL DEFAULT \'\' COMMENT \'Отправитель СМС\'');
        $this->addColumn('group', 'sms_text', 'VARCHAR(255) NULL DEFAULT \'\' COMMENT \'Текст СМС\'');
	}

	public function safeDown()
	{
        $this->dropTable(
            'status_log'
        );

        $this->dropTable(
            'setting'
        );

        $this->dropTable(
            'sms'
        );

        $this->dropColumn('group', 'is_sms_auto_send');
        $this->dropColumn('group', 'is_sms_send_period');
        $this->dropColumn('group', 'sms_sender');
        $this->dropColumn('group', 'sms_text');
    }
}