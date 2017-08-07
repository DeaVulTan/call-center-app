<?php

class m150129_193513_add_field_for_settings extends CDbMigration
{
    public function safeUp()
    {
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_call_to_empty_group_text',
                'category_id' => 3,
                'title' => 'Звонок в службу, в которой нет операторов (сообщение)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_call_to_empty_group_phone',
                'category_id' => 3,
                'title' => 'Звонок в службу, в которой нет операторов (телефон)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_call_to_empty_group_email',
                'category_id' => 3,
                'title' => 'Звонок в службу, в которой нет операторов (email)',
                'value' => ''
            ]
        );


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
                'name' => 'sys_msg_percent_call_served_limit_low_text',
                'category_id' => 3,
                'title' => 'Процент обслуженных вызовов ниже установленного предела (сообщение)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_percent_call_served_limit_low_limit',
                'category_id' => 3,
                'title' => 'Процент обслуженных вызовов ниже установленного предела (предельное значение)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_percent_call_served_limit_low_phone',
                'category_id' => 3,
                'title' => 'Процент обслуженных вызовов ниже установленного предела (телефон)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_percent_call_served_limit_low_email',
                'category_id' => 3,
                'title' => 'Процент обслуженных вызовов ниже установленного предела (email)',
                'value' => ''
            ]
        );


        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_call_count_high_text',
                'category_id' => 3,
                'title' => 'Количество звонков в службу превысило предел (сообщение)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_call_count_high_phone',
                'category_id' => 3,
                'title' => 'Количество звонков в службу превысило предел (телефон)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_call_count_high_email',
                'category_id' => 3,
                'title' => 'Количество звонков в службу превысило предел (email)',
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


        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_hdd_free_space_warning_text',
                'category_id' => 3,
                'title' => 'Уровень заполнения жесткого диска для отправки сообщения (сообщение)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_hdd_free_space_warning_limit',
                'category_id' => 3,
                'title' => 'Уровень заполнения жесткого диска для отправки сообщения (предельное значение)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_hdd_free_space_warning_phone',
                'category_id' => 3,
                'title' => 'Уровень заполнения жесткого диска для отправки сообщения (телефон)',
                'value' => ''
            ]
        );
        $this->insert(
            'setting',
            [
                'name' => 'sys_msg_hdd_free_space_warning_email',
                'category_id' => 3,
                'title' => 'Уровень заполнения жесткого диска для отправки сообщения (email)',
                'value' => ''
            ]
        );
    }

    public function safeDown()
    {
        $this->delete('setting', "name = 'sys_msg_call_to_empty_group_text'");
        $this->delete('setting', "name = 'sys_msg_call_to_empty_group_phone'");
        $this->delete('setting', "name = 'sys_msg_call_to_empty_group_email'");
        $this->delete('setting', "name = 'sys_msg_waiting_time_user_text'");
        $this->delete('setting', "name = 'sys_msg_waiting_time_user_limit'");
        $this->delete('setting', "name = 'sys_msg_waiting_time_user_phone'");
        $this->delete('setting', "name = 'sys_msg_waiting_time_user_email'");
        $this->delete('setting', "name = 'sys_msg_percent_call_served_limit_low_text'");
        $this->delete('setting', "name = 'sys_msg_percent_call_served_limit_low_limit'");
        $this->delete('setting', "name = 'sys_msg_percent_call_served_limit_low_phone'");
        $this->delete('setting', "name = 'sys_msg_percent_call_served_limit_low_email'");
        $this->delete('setting', "name = 'sys_msg_call_count_high_text'");
        $this->delete('setting', "name = 'sys_msg_call_count_high_phone'");
        $this->delete('setting', "name = 'sys_msg_call_count_high_email'");
        $this->delete('setting', "name = 'sys_msg_drop_channel_down_text'");
        $this->delete('setting', "name = 'sys_msg_drop_channel_down_phone'");
        $this->delete('setting', "name = 'sys_msg_drop_channel_down_email'");
        $this->delete('setting', "name = 'sys_msg_drop_channel_up_text'");
        $this->delete('setting', "name = 'sys_msg_drop_channel_up_phone'");
        $this->delete('setting', "name = 'sys_msg_drop_channel_up_email'");
        $this->delete('setting', "name = 'sys_msg_hdd_free_space_warning_text'");
        $this->delete('setting', "name = 'sys_msg_hdd_free_space_warning_limit'");
        $this->delete('setting', "name = 'sys_msg_hdd_free_space_warning_phone'");
        $this->delete('setting', "name = 'sys_msg_hdd_free_space_warning_email'");
    }
}