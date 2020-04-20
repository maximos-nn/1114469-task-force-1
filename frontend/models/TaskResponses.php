<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "task_responses".
 *
 * @property int $id
 * @property string $creation_time
 * @property int $task_id
 * @property int $profile_id
 * @property int|null $price
 * @property string|null $comment
 * @property string|null $decline_time
 *
 * @property Profiles $profile
 * @property Tasks $task
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
            [['task_id', 'profile_id'], 'required'],
            [['task_id', 'profile_id', 'price'], 'integer'],
            [['comment'], 'string'],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
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
            'profile_id' => 'Profile ID',
            'price' => 'Price',
            'comment' => 'Comment',
            'decline_time' => 'Decline Time',
        ];
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profiles::className(), ['id' => 'profile_id']);
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
}
