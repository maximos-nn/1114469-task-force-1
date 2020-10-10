<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_messages}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tasks}}`
 * - `{{%users}}`
 * - `{{%users}}`
 */
class m201009_045946_create_task_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_messages}}', [
            'id' => $this->primaryKey()->unsigned(),
            'creation_time' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'task_id' => $this->integer()->unsigned()->notNull(),
            'from_id' => $this->integer()->unsigned()->notNull(),
            'to_id' => $this->integer()->unsigned()->notNull(),
            'text' => $this->text()->notNull(),
        ]);

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-task_messages-task_id}}',
            '{{%task_messages}}',
            'task_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-task_messages-task_id}}',
            '{{%task_messages}}',
            'task_id',
            '{{%tasks}}',
            'id',
            'CASCADE'
        );

        // creates index for column `from_id`
        $this->createIndex(
            '{{%idx-task_messages-from_id}}',
            '{{%task_messages}}',
            'from_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-task_messages-from_id}}',
            '{{%task_messages}}',
            'from_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `to_id`
        $this->createIndex(
            '{{%idx-task_messages-to_id}}',
            '{{%task_messages}}',
            'to_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-task_messages-to_id}}',
            '{{%task_messages}}',
            'to_id',
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
        // drops foreign key for table `{{%tasks}}`
        $this->dropForeignKey(
            '{{%fk-task_messages-task_id}}',
            '{{%task_messages}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-task_messages-task_id}}',
            '{{%task_messages}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-task_messages-from_id}}',
            '{{%task_messages}}'
        );

        // drops index for column `from_id`
        $this->dropIndex(
            '{{%idx-task_messages-from_id}}',
            '{{%task_messages}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-task_messages-to_id}}',
            '{{%task_messages}}'
        );

        // drops index for column `to_id`
        $this->dropIndex(
            '{{%idx-task_messages-to_id}}',
            '{{%task_messages}}'
        );

        $this->dropTable('{{%task_messages}}');
    }
}
