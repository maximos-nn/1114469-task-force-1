<?php

use yii\db\Migration;

/**
 * Class m200921_081616_update_task_expire_dates
 */
class m200921_081616_update_task_expire_dates extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('UPDATE tasks SET expire_date = DATE_ADD(expire_date, INTERVAL 1 YEAR);');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('UPDATE tasks SET expire_date = DATE_SUB(expire_date, INTERVAL 1 YEAR);');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200921_081616_update_task_expire_dates cannot be reverted.\n";

        return false;
    }
    */
}
