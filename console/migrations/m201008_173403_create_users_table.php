<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%cities}}`
 * - `{{%files}}`
 */
class m201008_173403_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey()->unsigned(),
            'creation_time' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'email' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'city_id' => $this->integer()->unsigned()->notNull(),
            'avatar_file_id' => $this->integer()->unsigned(),
            'birthday' => $this->date(),
            'info' => $this->text(),
            'phone' => $this->string(),
            'skype' => $this->string(),
            'telegram' => $this->string(),
            'last_action' => $this->datetime(),
        ]);

        // creates index for column `city_id`
        $this->createIndex(
            '{{%idx-users-city_id}}',
            '{{%users}}',
            'city_id'
        );

        // add foreign key for table `{{%cities}}`
        $this->addForeignKey(
            '{{%fk-users-city_id}}',
            '{{%users}}',
            'city_id',
            '{{%cities}}',
            'id',
            'CASCADE'
        );

        // creates index for column `avatar_file_id`
        $this->createIndex(
            '{{%idx-users-avatar_file_id}}',
            '{{%users}}',
            'avatar_file_id'
        );

        // add foreign key for table `{{%files}}`
        $this->addForeignKey(
            '{{%fk-users-avatar_file_id}}',
            '{{%users}}',
            'avatar_file_id',
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
        // drops foreign key for table `{{%cities}}`
        $this->dropForeignKey(
            '{{%fk-users-city_id}}',
            '{{%users}}'
        );

        // drops index for column `city_id`
        $this->dropIndex(
            '{{%idx-users-city_id}}',
            '{{%users}}'
        );

        // drops foreign key for table `{{%files}}`
        $this->dropForeignKey(
            '{{%fk-users-avatar_file_id}}',
            '{{%users}}'
        );

        // drops index for column `avatar_file_id`
        $this->dropIndex(
            '{{%idx-users-avatar_file_id}}',
            '{{%users}}'
        );

        $this->dropTable('{{%users}}');
    }
}
