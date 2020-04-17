<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "task_messages".
 *
 * @property int $id
 * @property string $creation_time
 * @property int $task_id
 * @property int $from_id
 * @property int $to_id
 * @property string $text
 *
 * @property Tasks $task
 */
class TaskMessages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time'], 'safe'],
            [['task_id', 'from_id', 'to_id', 'text'], 'required'],
            [['task_id', 'from_id', 'to_id'], 'integer'],
            [['text'], 'string'],
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
            'from_id' => 'From ID',
            'to_id' => 'To ID',
            'text' => 'Text',
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
}
