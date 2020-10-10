<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_responses}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tasks}}`
 * - `{{%users}}`
 */
class m201009_045405_create_task_responses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_responses}}', [
            'id' => $this->primaryKey()->unsigned(),
            'creation_time' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'task_id' => $this->integer()->unsigned()->notNull(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'price' => $this->integer()->unsigned(),
            'comment' => $this->text(),
            'decline_time' => $this->datetime(),
        ]);

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-task_responses-task_id}}',
            '{{%task_responses}}',
            'task_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-task_responses-task_id}}',
            '{{%task_responses}}',
            'task_id',
            '{{%tasks}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-task_responses-user_id}}',
            '{{%task_responses}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-task_responses-user_id}}',
            '{{%task_responses}}',
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
        // drops foreign key for table `{{%tasks}}`
        $this->dropForeignKey(
            '{{%fk-task_responses-task_id}}',
            '{{%task_responses}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-task_responses-task_id}}',
            '{{%task_responses}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-task_responses-user_id}}',
            '{{%task_responses}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-task_responses-user_id}}',
            '{{%task_responses}}'
        );

        $this->dropTable('{{%task_responses}}');
    }
}
