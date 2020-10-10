<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_favourites}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%users}}`
 */
class m201008_180321_create_user_favourites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_favourites}}', [
            'id' => $this->primaryKey()->unsigned(),
            'favored_by_id' => $this->integer()->unsigned()->notNull(),
            'favourite_id' => $this->integer()->unsigned()->notNull(),
        ]);

        // creates index for column `favored_by_id`
        $this->createIndex(
            '{{%idx-user_favourites-favored_by_id-favourite_id}}',
            '{{%user_favourites}}',
            ['favored_by_id', 'favourite_id'],
            true
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-user_favourites-favored_by_id}}',
            '{{%user_favourites}}',
            'favored_by_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `favourite_id`
        $this->createIndex(
            '{{%idx-user_favourites-favourite_id}}',
            '{{%user_favourites}}',
            'favourite_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-user_favourites-favourite_id}}',
            '{{%user_favourites}}',
            'favourite_id',
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
            '{{%fk-user_favourites-favored_by_id}}',
            '{{%user_favourites}}'
        );

        // drops index for column `favored_by_id`
        $this->dropIndex(
            '{{%idx-user_favourites-favored_by_id-favourite_id}}',
            '{{%user_favourites}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-user_favourites-favourite_id}}',
            '{{%user_favourites}}'
        );

        // drops index for column `favourite_id`
        $this->dropIndex(
            '{{%idx-user_favourites-favourite_id}}',
            '{{%user_favourites}}'
        );

        $this->dropTable('{{%user_favourites}}');
    }
}
