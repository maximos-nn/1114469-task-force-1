<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_settings".
 *
 * @property int $id
 * @property int $user_id
 * @property int $notify_message
 * @property int $notify_assign
 * @property int $notify_finish
 * @property int $notify_refuse
 * @property int $notify_feedback
 * @property int $hide_contacts
 * @property int $hide_profile
 *
 * @property Users $user
 */
class UserSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'notify_message', 'notify_assign', 'notify_finish', 'notify_refuse', 'notify_feedback', 'hide_contacts', 'hide_profile'], 'integer'],
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
            'notify_message' => 'Notify Message',
            'notify_assign' => 'Notify Assign',
            'notify_finish' => 'Notify Finish',
            'notify_refuse' => 'Notify Refuse',
            'notify_feedback' => 'Notify Feedback',
            'hide_contacts' => 'Hide Contacts',
            'hide_profile' => 'Hide Profile',
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
