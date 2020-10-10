<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "task_responses".
 *
 * @property int $id
 * @property string $creation_time
 * @property int $task_id
 * @property int $user_id
 * @property int|null $price
 * @property string|null $comment
 * @property string|null $decline_time
 *
 * @property Tasks $task
 * @property Users $user
 */
class TaskResponses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_responses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time', 'decline_time'], 'safe'],
            [['task_id', 'user_id'], 'required'],
            [['task_id', 'user_id', 'price'], 'integer'],
            [['comment'], 'string'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
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
            'creation_time' => 'Creation Time',
            'task_id' => 'Task ID',
            'user_id' => 'User ID',
            'price' => 'Price',
            'comment' => 'Comment',
            'decline_time' => 'Decline Time',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
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
