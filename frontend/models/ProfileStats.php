<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "profile_stats".
 *
 * @property int $id
 * @property int $profile_id
 * @property int $tasks_total
 * @property int $tasks_failed
 * @property int $views
 * @property int $avg_rate
 *
 * @property Profiles $profile
 */
class ProfileStats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_stats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id'], 'required'],
            [['profile_id', 'tasks_total', 'tasks_failed', 'views', 'avg_rate'], 'integer'],
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
            'tasks_total' => 'Tasks Total',
            'tasks_failed' => 'Tasks Failed',
            'views' => 'Views',
            'avg_rate' => 'Avg Rate',
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
