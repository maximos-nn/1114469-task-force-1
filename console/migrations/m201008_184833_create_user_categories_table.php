<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_categories}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%categories}}`
 */
class m201008_184833_create_user_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_categories}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'category_id' => $this->integer()->unsigned()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_categories-user_id-category_id}}',
            '{{%user_categories}}',
            ['user_id', 'category_id'],
            true
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-user_categories-user_id}}',
            '{{%user_categories}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-user_categories-category_id}}',
            '{{%user_categories}}',
            'category_id'
        );

        // add foreign key for table `{{%categories}}`
        $this->addForeignKey(
            '{{%fk-user_categories-category_id}}',
            '{{%user_categories}}',
            'category_id',
            '{{%categories}}',
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
            '{{%fk-user_categories-user_id}}',
            '{{%user_categories}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_categories-user_id-category_id}}',
            '{{%user_categories}}'
        );

        // drops foreign key for table `{{%categories}}`
        $this->dropForeignKey(
            '{{%fk-user_categories-category_id}}',
            '{{%user_categories}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-user_categories-category_id}}',
            '{{%user_categories}}'
        );

        $this->dropTable('{{%user_categories}}');
    }
}
