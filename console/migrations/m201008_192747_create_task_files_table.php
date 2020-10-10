<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_files}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tasks}}`
 * - `{{%files}}`
 */
class m201008_192747_create_task_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_files}}', [
            'id' => $this->primaryKey()->unsigned(),
            'task_id' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string()->notNull(),
            'file_id' => $this->integer()->unsigned()->notNull(),
        ]);

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-task_files-task_id}}',
            '{{%task_files}}',
            'task_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-task_files-task_id}}',
            '{{%task_files}}',
            'task_id',
            '{{%tasks}}',
            'id',
            'CASCADE'
        );

        // creates index for column `file_id`
        $this->createIndex(
            '{{%idx-task_files-file_id}}',
            '{{%task_files}}',
            'file_id'
        );

        // add foreign key for table `{{%files}}`
        $this->addForeignKey(
            '{{%fk-task_files-file_id}}',
            '{{%task_files}}',
            'file_id',
            '{{%files}}',
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
            '{{%fk-task_files-task_id}}',
            '{{%task_files}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-task_files-task_id}}',
            '{{%task_files}}'
        );

        // drops foreign key for table `{{%files}}`
        $this->dropForeignKey(
            '{{%fk-task_files-file_id}}',
            '{{%task_files}}'
        );

        // drops index for column `file_id`
        $this->dropIndex(
            '{{%idx-task_files-file_id}}',
            '{{%task_files}}'
        );

        $this->dropTable('{{%task_files}}');
    }
}
