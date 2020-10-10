<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%categories}}`
 * - `{{%cities}}`
 * - `{{%users}}`
 */
class m201008_191650_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey()->unsigned(),
            'creation_time' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'category_id' => $this->integer()->unsigned()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'budget' => $this->integer()->unsigned(),
            'expire_date' => $this->datetime(),
            'city_id' => $this->integer()->unsigned()->notNull(),
            'latitude' => $this->decimal(10, 8),
            'longitude' => $this->decimal(11, 8),
            'contractor_id' => $this->integer()->unsigned(),
            'assign_time' => $this->datetime(),
            'canceled_time' => $this->datetime(),
            'failed_time' => $this->datetime(),
            'status' => $this->tinyinteger(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-tasks-user_id}}',
            '{{%tasks}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-tasks-user_id}}',
            '{{%tasks}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-tasks-category_id}}',
            '{{%tasks}}',
            'category_id'
        );

        // add foreign key for table `{{%categories}}`
        $this->addForeignKey(
            '{{%fk-tasks-category_id}}',
            '{{%tasks}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );

        // creates index for column `city_id`
        $this->createIndex(
            '{{%idx-tasks-city_id}}',
            '{{%tasks}}',
            'city_id'
        );

        // add foreign key for table `{{%cities}}`
        $this->addForeignKey(
            '{{%fk-tasks-city_id}}',
            '{{%tasks}}',
            'city_id',
            '{{%cities}}',
            'id',
            'CASCADE'
        );

        // creates index for column `contractor_id`
        $this->createIndex(
            '{{%idx-tasks-contractor_id}}',
            '{{%tasks}}',
            'contractor_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-tasks-contractor_id}}',
            '{{%tasks}}',
            'contractor_id',
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
            '{{%fk-tasks-user_id}}',
            '{{%tasks}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-tasks-user_id}}',
            '{{%tasks}}'
        );

        // drops foreign key for table `{{%categories}}`
        $this->dropForeignKey(
            '{{%fk-tasks-category_id}}',
            '{{%tasks}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-tasks-category_id}}',
            '{{%tasks}}'
        );

        // drops foreign key for table `{{%cities}}`
        $this->dropForeignKey(
            '{{%fk-tasks-city_id}}',
            '{{%tasks}}'
        );

        // drops index for column `city_id`
        $this->dropIndex(
            '{{%idx-tasks-city_id}}',
            '{{%tasks}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-tasks-contractor_id}}',
            '{{%tasks}}'
        );

        // drops index for column `contractor_id`
        $this->dropIndex(
            '{{%idx-tasks-contractor_id}}',
            '{{%tasks}}'
        );

        $this->dropTable('{{%tasks}}');
    }
}
