<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_stats".
 *
 * @property int $id
 * @property int $user_id
 * @property int $tasks_total
 * @property int $tasks_failed
 * @property int $views
 * @property int $avg_rate
 *
 * @property Users $user
 */
class UserStats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_stats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'tasks_total', 'tasks_failed', 'views', 'avg_rate'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'tasks_total' => 'Tasks Total',
            'tasks_failed' => 'Tasks Failed',
            'views' => 'Views',
            'avg_rate' => 'Avg Rate',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
