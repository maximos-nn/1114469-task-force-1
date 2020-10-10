<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_portfolios}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%files}}`
 */
class m201008_185612_create_user_portfolios_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_portfolios}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'file_id' => $this->integer()->unsigned()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_portfolios-user_id}}',
            '{{%user_portfolios}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-user_portfolios-user_id}}',
            '{{%user_portfolios}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `file_id`
        $this->createIndex(
            '{{%idx-user_portfolios-file_id}}',
            '{{%user_portfolios}}',
            'file_id'
        );

        // add foreign key for table `{{%files}}`
        $this->addForeignKey(
            '{{%fk-user_portfolios-file_id}}',
            '{{%user_portfolios}}',
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
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-user_portfolios-user_id}}',
            '{{%user_portfolios}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_portfolios-user_id}}',
            '{{%user_portfolios}}'
        );

        // drops foreign key for table `{{%files}}`
        $this->dropForeignKey(
            '{{%fk-user_portfolios-file_id}}',
            '{{%user_portfolios}}'
        );

        // drops index for column `file_id`
        $this->dropIndex(
            '{{%idx-user_portfolios-file_id}}',
            '{{%user_portfolios}}'
        );

        $this->dropTable('{{%user_portfolios}}');
    }
}
