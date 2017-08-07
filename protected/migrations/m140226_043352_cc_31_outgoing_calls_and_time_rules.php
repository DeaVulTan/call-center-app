<?php

class m140226_043352_cc_31_outgoing_calls_and_time_rules extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('group', 'music_file_id', 'INT NULL DEFAULT NULL COMMENT \'id музыки на удержании\'');
        $this->createIndex('fk_group_music_file_idx', 'group', 'music_file_id');
        $this->addForeignKey(
            'fk_group_music_file',
            'group',
            'music_file_id',
            'music_on_hold_file',
            'id',
            'SET NULL',
            'SET NULL'
        );
        $this->addColumn('group', 'call_distribution', 'VARCHAR(45) NOT NULL COMMENT \'системное название параметка\'');

        $this->addColumn('note_field', 'is_important', 'INT NOT NULL DEFAULT 0 COMMENT \'обязательность поля\'');


        $this->addColumn('sip_devices', 'is_need_registration', 'INT NOT NULL DEFAULT 0 COMMENT \'требуется регистрация\'');
        $this->addColumn('sip_devices', 'as_number', 'VARCHAR(20) NOT NULL DEFAULT \'\' COMMENT \'регистрироваться как номер\'');

        $this->createTable(
            'outgoing_rule',
            [
                'id'        => 'BIGINT(20) NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'name'      => 'VARCHAR(100) NOT NULL COMMENT \'название правила\'',
                'len'       => 'INT COMMENT \'длина номера\'',
                'prefix'    => 'VARCHAR(100) NULL COMMENT \'префикс\'',
                'cut'       => 'INT NULL COMMENT \'отрезать кол-во символов в начале номера\'',
                'add'       => 'VARCHAR(255) NULL COMMENT \'добавить в начало номера\'',
                'callerid'  => 'VARCHAR(255) NULL COMMENT \'время выхода из статуса\'',
                'trunk'     => 'INT NULL COMMENT \'транк\'',
            ],
            'ENGINE = InnoDB CHARSET=utf8 COMMENT = \'исходящая маршрутизация\''
        );
        $this->createTable(
            'time_condition',
            [
                'id'            => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'name'          => 'VARCHAR(200) NOT NULL COMMENT \'название правила\'',
                'event_true'    => 'VARCHAR(100) NULL COMMENT \'действие, если звонок попадает в указанный диапазон времени\'',
                'value_true'    => 'VARCHAR(100) NULL COMMENT \'параметр действия, если звонок попадает в указанный диапазон времени\'',
                'event_false'   => 'VARCHAR(100) NULL COMMENT \'действие, если звонок не попадает в указанный диапазон времени\'',
                'value_false'   => 'VARCHAR(100) NULL COMMENT \'параметр действия, если звонок не попадает в указанный диапазон времени\'',
            ],
            'ENGINE = InnoDB CHARSET=utf8 COMMENT = \'правила по времени\''
        );
        $this->createTable(
            'time_rule',
            [
                'id'            => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'condition_id'  => 'INT NULL COMMENT \'id правила по времени\'',
                'time'          => 'VARCHAR(11) NOT NULL DEFAULT \'*\' COMMENT \'действие, если звонок попадает в указанный диапазон времени\'',
                'dow'           => 'VARCHAR(500) NOT NULL DEFAULT \'*\' COMMENT \'параметр действия, если звонок попадает в указанный диапазон времени\'',
                'dom'           => 'VARCHAR(500) NOT NULL DEFAULT \'*\' COMMENT \'действие, если звонок не попадает в указанный диапазон времени\'',
                'mon'           => 'VARCHAR(500) NOT NULL DEFAULT \'*\' COMMENT \'параметр действия, если звонок не попадает в указанный диапазон времени\'',
            ],
            'ENGINE = InnoDB CHARSET=utf8 COMMENT = \'временные диапазоны\''
        );
        $this->createIndex('fk_time_rule_condition_id_idx', 'time_rule', 'condition_id');
        $this->addForeignKey(
            'fk_time_rule_condition_id',
            'time_rule',
            'condition_id',
            'time_condition',
            'id',
            'SET NULL',
            'SET NULL'
        );
	}

	public function safeDown()
	{
        $this->dropForeignKey('fk_time_rule_condition_id', 'time_rule');
        $this->dropIndex('fk_time_rule_condition_id_idx', 'time_rule');
        $this->dropTable('time_rule');
        $this->dropTable('time_condition');
        $this->dropTable('outgoing_rule');

        $this->dropColumn('sip_devices', 'is_need_registration');
        $this->dropColumn('sip_devices', 'as_number');

        $this->dropColumn('note_field', 'is_important');

        $this->dropForeignKey('fk_group_music_file', 'group');
        $this->dropIndex('fk_group_music_file_idx', 'group');
        $this->dropColumn('group', 'music_file_id');
        $this->dropColumn('group', 'call_distribution');
    }
}