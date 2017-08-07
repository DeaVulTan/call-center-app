<?php

class m150914_192623_tables_for_autodial extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            'autodial_main',
            [
                'id' => 'BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'name' => 'VARCHAR(255) NOT NULL DEFAULT \'\' COMMENT \'название\'',
                'dir' => 'VARCHAR(60) NOT NULL DEFAULT \'\' COMMENT \'директория для записей\'',
                'starttime' => 'DATETIME NOT NULL DEFAULT \'0000-00-00 00:00:00\' COMMENT \'начало обзвона\'',
                'stoptime' => 'DATETIME NOT NULL DEFAULT \'0000-00-00 00:00:00\' COMMENT \'конец обзвона\'',
                'worktimestart' => 'TIME NOT NULL DEFAULT \'00:00:00\' COMMENT \'допустимое время звонка "С" (ЧЧ:ММ)\'',
                'worktimestop' => 'TIME NOT NULL DEFAULT \'00:00:00\' COMMENT \'допустимое время звонка "По" (ЧЧ:ММ)\'',
                'exeption_day' => 'VARCHAR(13) NOT NULL DEFAULT \'\' COMMENT \'дни исключений\'',
                'predict_group' => 'INT NOT NULL DEFAULT 0 COMMENT \'служба для предикта\'',
                'predict_add_calls' => 'INT NOT NULL DEFAULT 0 COMMENT \'коэфф. ускорения для предикта\'',
                'status' => 'TINYINT NOT NULL DEFAULT 2 COMMENT \'статус задания (0 - stopped, 1 - started, 2 - paused)\'',
                'iter' => 'INT NOT NULL DEFAULT 0 COMMENT \'кол-во повторений\'',
                'callcount' => 'INT NOT NULL DEFAULT 0 COMMENT \'кол-во одновременных вызовов\'',
                'event' => 'INT NOT NULL DEFAULT 0 COMMENT \'событие\'',
                'value' => 'INT NOT NULL DEFAULT 0 COMMENT \'значение\'',
                'trunk_id' => 'INT NOT NULL DEFAULT 0 COMMENT \'транк\'',
                'prefix' => 'VARCHAR(60) NOT NULL DEFAULT \'\' COMMENT \'префикс\'',
                'regular' => 'INT NOT NULL DEFAULT 0 COMMENT \'Регулярное задание\'',
                'regular_time' => 'VARCHAR(5) NOT NULL DEFAULT \'\' COMMENT \'Время ругулярного задания\'',
                'record' => 'INT NOT NULL DEFAULT 0 COMMENT \'Записывать разговоры\'',
                'success_dial' => 'INT NOT NULL DEFAULT 0 COMMENT \'Успешность дозвона ("Отвечен" - 1, "Прослушано сек." - 2, "Прослушано полностью" - 3)\'',
                'success_sec' => 'INT NOT NULL DEFAULT 0 COMMENT \'Прослушано сек.\'',
                'iter_delay' => 'INT NOT NULL DEFAULT 0 COMMENT \'Интервалы повторений\'',
                'callerid' => 'VARCHAR(60) NOT NULL DEFAULT 0 COMMENT \'Внешний номер\'',
            ],
            'ENGINE = InnoDB CHARSET=utf8 COMMENT = \'автообзвон\''
        );

        $this->createTable(
            'autodial_numbers',
            [
                'id' => 'BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'autodialid' => 'INT NOT NULL DEFAULT 0 COMMENT \'id задания автообзвона\'',
                'number' => 'VARCHAR(100) NOT NULL DEFAULT \'\' COMMENT \'телефонный номер\'',
                'trytime' => 'DATETIME NOT NULL DEFAULT \'0000-00-00 00:00:00\' COMMENT \'время попытки дозвона\'',
                'iter' => 'INT NOT NULL DEFAULT 0 COMMENT \'остаток повторений дозвона на номер\'',
                'status' => 'TINYINT NOT NULL DEFAULT 0 COMMENT \'0-не было попыток, 1-дозвонились, 2-попытка дозвона\'',
            ],
            'ENGINE = InnoDB CHARSET=utf8 COMMENT = \'номера для автообзвона\''
        );

        return true;
	}

	public function down()
	{
        $this->dropTable('autodial_main');
        $this->dropTable('autodial_numbers');

		return true;
	}
}
