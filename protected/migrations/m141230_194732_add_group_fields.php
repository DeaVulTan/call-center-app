<?php

class m141230_194732_add_group_fields extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->addColumn('group', 'sla', 'VARCHAR(32) NOT NULL COMMENT \'SLA\'');
        $this->addColumn('group', 'is_need_notes', 'INT(1) NOT NULL DEFAULT 0 COMMENT \'Использовать в службе заметки\'');
        $this->addColumn('group', 'is_sms_timeout', 'INT(1) NOT NULL DEFAULT 0 COMMENT \'Отправлять СМС о превышении времени ожидания\'');
        $this->addColumn('group', 'is_sms_percent', 'INT(1) NOT NULL DEFAULT 0 COMMENT \'Отправлять СМС о падении процента обслуженных\'');
        $this->addColumn('group', 'is_sms_limit', 'INT(1) NOT NULL DEFAULT 0 COMMENT \'Отправлять СМС о превышении порога звонков\'');
    }

    public function safeDown()
    {
        $this->dropColumn('group', 'sla');
        $this->dropColumn('group', 'is_need_notes');
        $this->dropColumn('group', 'is_sms_timeout');
        $this->dropColumn('group', 'is_sms_percent');
        $this->dropColumn('group', 'is_sms_limit');
    }
}
