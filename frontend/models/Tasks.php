<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $creation_time
 * @property int $profile_id
 * @property int $category_id
 * @property string $title
 * @property string $description
 * @property int|null $budget
 * @property string|null $expire_date
 * @property int $city_id
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int|null $contractor_id
 * @property string|null $assign_time
 * @property string|null $canceled_time
 * @property string|null $failed_time
 * @property int|null $status
 *
 * @property TaskFeedbacks[] $taskFeedbacks
 * @property TaskFiles[] $taskFiles
 * @property TaskMessages[] $taskMessages
 * @property TaskResponses[] $taskResponses
 * @property Categories $category
 * @property Cities $city
 * @property Profiles $profile
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time', 'expire_date', 'assign_time', 'canceled_time', 'failed_time'], 'safe'],
            [['profile_id', 'category_id', 'title', 'description', 'city_id'], 'required'],
            [['profile_id', 'category_id', 'budget', 'city_id', 'contractor_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['latitude', 'longitude'], 'number'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
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
            'creation_time' => 'Creation Time',
            'profile_id' => 'Profile ID',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'description' => 'Description',
            'budget' => 'Budget',
            'expire_date' => 'Expire Date',
            'city_id' => 'City ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'contractor_id' => 'Contractor ID',
            'assign_time' => 'Assign Time',
            'canceled_time' => 'Canceled Time',
            'failed_time' => 'Failed Time',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[TaskFeedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFeedbacks()
    {
        return $this->hasMany(TaskFeedbacks::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFiles::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TaskMessages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskMessages()
    {
        return $this->hasMany(TaskMessages::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TaskResponses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskResponses()
    {
        return $this->hasMany(TaskResponses::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
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
