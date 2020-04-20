<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "profile_settings".
 *
 * @property int $id
 * @property int $profile_id
 * @property int $notify_message
 * @property int $notify_assign
 * @property int $notify_finish
 * @property int $notify_refuse
 * @property int $notify_feedback
 * @property int $hide_contacts
 * @property int $hide_profile
 *
 * @property Profiles $profile
 */
class ProfileSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id'], 'required'],
            [['profile_id', 'notify_message', 'notify_assign', 'notify_finish', 'notify_refuse', 'notify_feedback', 'hide_contacts', 'hide_profile'], 'integer'],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_id' => 'Profile ID',
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
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profiles::className(), ['id' => 'profile_id']);
    }
}
