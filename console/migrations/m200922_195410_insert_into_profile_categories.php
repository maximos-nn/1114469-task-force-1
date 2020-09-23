<?php

use yii\db\Migration;

/**
 * Class m200922_195410_insert_into_profile_categories
 */
class m200922_195410_insert_into_profile_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute(
            'INSERT INTO profile_categories (profile_id, category_id)
            SELECT pr.id,
                (SELECT id FROM categories ORDER BY rand() LIMIT 1)
            FROM profiles pr LEFT JOIN tasks t ON pr.id = t.profile_id
            WHERE t.id IS NULL;'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('TRUNCATE profile_categories;');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200922_195410_insert_into_profile_categories cannot be reverted.\n";

        return false;
    }
    */
}
