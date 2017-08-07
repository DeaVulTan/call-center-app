<?php

class m151012_184310_settings_change extends CDbMigration
{
	public function up()
	{
        $this->delete('setting', "name = 'sys_msg_waiting_time_user_text'");
        $this->delete('setting', "name = 'sys_msg_waiting_time_user_limit'");
        $this->delete('setting', "name = 'sys_msg_waiting_time_user_phone'");
        $this->delete('setting', "name = 'sys_msg_waiting_time_user_email'");
        $this->delete('setting', "name = 'sys_msg_drop_channel_down_text'");
        $this->delete('setting', "name = 'sys_msg_drop_channel_down_phone'");
        $this->delete('setting', "name = 'sys_msg_drop_channel_down_email'");
        $this->delete('setting', "name = 'sys_msg_drop_channel_up_text'");
        $this->delete('setting', "name = 'sys_msg_drop_channel_up_phone'");
        $this->delete('setting', "name = 'sys_msg_drop_channel_up_email'");

        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_mailer_smtp',
                'category_id' => 3,
                'title' => 'Настроки почты (SMTP-сервер)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_mailer_port',
                'category_id' => 3,
                'title' => 'Настроки почты (порт)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_mailer_address',
                'category_id' => 3,
                'title' => 'Настроки почты (адрес отправителя)',
                'value' => ''
            ]
        );
        $this->addColumn('group', 'is_empty_group_sms', 'TINYINT(1) NOT NULL DEFAULT 0 COMMENT \'Отправлять СМС при звонках когда в службе нет операторов\'');
	}

	public function down()
	{
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_waiting_time_user_text',
                'category_id' => 3,
                'title' => 'Время ожидания абонента (сообщение)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_waiting_time_user_limit',
                'category_id' => 3,
                'title' => 'Время ожидания абонента (предельное значение)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_waiting_time_user_phone',
                'category_id' => 3,
                'title' => 'Время ожидания абонента (телефон)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_waiting_time_user_email',
                'category_id' => 3,
                'title' => 'Время ожидания абонента (email)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_drop_channel_down_text',
                'category_id' => 3,
                'title' => 'Падение канала Е1 (Down) (сообщение)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_drop_channel_down_phone',
                'category_id' => 3,
                'title' => 'Падение канала Е1 (Down) (телефон)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_drop_channel_down_email',
                'category_id' => 3,
                'title' => 'Падение канала Е1 (Down) (email)',
                'value' => ''
            ]
        );


        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_drop_channel_up_text',
                'category_id' => 3,
                'title' => 'Падение канала Е1 (Up) (сообщение)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_drop_channel_up_phone',
                'category_id' => 3,
                'title' => 'Падение канала Е1 (Up) (телефон)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_drop_channel_up_email',
                'category_id' => 3,
                'title' => 'Падение канала Е1 (Up) (email)',
                'value' => ''
            ]
        );
        $this->delete('setting', "name = 'sys_msg_mailer_smtp'");
        $this->delete('setting', "name = 'sys_msg_mailer_port'");
        $this->delete('setting', "name = 'sys_msg_mailer_address'");
        $this->dropColumn('group', 'is_empty_group_sms');
	}
}