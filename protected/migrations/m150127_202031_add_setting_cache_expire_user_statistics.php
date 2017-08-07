<?php

class m150127_202031_add_setting_cache_expire_user_statistics extends CDbMigration
{
    public function safeUp()
    {
        $this->insert(
            'setting',
            ['name' => 'cache_user_statistics_expire', 'category_id' => 2, 'title' => 'Время кеширования статистики пользователя (сек)', 'value' => 600]
        );
    }

    public function safeDown()
    {
        $this->delete('setting', "name = 'cache_user_statistics_expire'");
    }
}