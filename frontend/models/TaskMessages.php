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
 * @property Users $from
 * @property Tasks $task
 * @property Users $to
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
            [['from_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['from_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['to_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['to_id' => 'id']],
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
     * Gets query for [[From]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(Users::className(), ['id' => 'from_id']);
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
     * Gets query for [[To]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTo()
    {
        return $this->hasOne(Users::className(), ['id' => 'to_id']);
    }
}
