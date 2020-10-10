<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_settings}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m201008_181502_create_user_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_settings}}', [
            'id' => $this->primarykey()->unsigned(),
            'user_id' => $this->integer()->notNull()->unsigned(),
            'notify_message' => $this->boolean()->notNull()->defaultValue(true),
            'notify_assign' => $this->boolean()->notNull()->defaultValue(true),
            'notify_finish' => $this->boolean()->notNull()->defaultValue(true),
            'notify_refuse' => $this->boolean()->notNull()->defaultValue(true),
            'notify_feedback' => $this->boolean()->notNull()->defaultValue(true),
            'hide_contacts' => $this->boolean()->notNull()->defaultValue(false),
            'hide_profile' => $this->boolean()->notNull()->defaultValue(false),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_settings-user_id}}',
            '{{%user_settings}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-user_settings-user_id}}',
            '{{%user_settings}}',
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
            '{{%fk-user_settings-user_id}}',
            '{{%user_settings}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_settings-user_id}}',
            '{{%user_settings}}'
        );

        $this->dropTable('{{%user_settings}}');
    }
}
