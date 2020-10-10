<?php

use yii\db\Migration;

/**
 * Class m201009_071420_insert_categories
 */
class m201009_071420_insert_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            '{{%categories}}',
            ['name', 'alias'],
            [
                ['Курьерские услуги', 'translation'],
                ['Уборка', 'clean'],
                ['Переезды', 'cargo'],
                ['Компьютерная помощь', 'neo'],
                ['Ремонт квартирный', 'flat'],
                ['Ремонт техники', 'repair'],
                ['Красота', 'beauty'],
                ['Фото', 'photo']
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->truncateTable('{{%categories}}');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
