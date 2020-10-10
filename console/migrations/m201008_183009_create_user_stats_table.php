<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_stats}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m201008_183009_create_user_stats_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_stats}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'tasks_total' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'tasks_failed' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'views' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'avg_rate' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_stats-user_id}}',
            '{{%user_stats}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-user_stats-user_id}}',
            '{{%user_stats}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-user_stats-user_id}}',
            '{{%user_stats}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_stats-user_id}}',
            '{{%user_stats}}'
        );

        $this->dropTable('{{%user_stats}}');
    }
}
