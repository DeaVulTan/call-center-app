<?php

class m150415_195419_add_main_ivr_attribute extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('main_ivr', 'is_main', 'TINYINT(1) NOT NULL DEFAULT 0');
    }

    public function safeDown()
    {
        $this->dropColumn('main_ivr', 'is_main');
    }
}