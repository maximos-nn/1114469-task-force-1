<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_feedbacks}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tasks}}`
 */
class m201008_194106_create_task_feedbacks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_feedbacks}}', [
            'id' => $this->primaryKey()->unsigned(),
            'creation_time' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'task_id' => $this->integer()->unsigned()->notNull(),
            'comment' => $this->text(),
            'rate' => $this->tinyinteger(1)->unsigned()->notNull()->defaultValue(0),
        ]);

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-task_feedbacks-task_id}}',
            '{{%task_feedbacks}}',
            'task_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-task_feedbacks-task_id}}',
            '{{%task_feedbacks}}',
            'task_id',
            '{{%tasks}}',
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
            '{{%fk-task_feedbacks-task_id}}',
            '{{%task_feedbacks}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-task_feedbacks-task_id}}',
            '{{%task_feedbacks}}'
        );

        $this->dropTable('{{%task_feedbacks}}');
    }
}
