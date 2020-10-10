<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $creation_time
 * @property string $email
 * @property string $password
 * @property string $name
 * @property int $city_id
 * @property int|null $avatar_file_id
 * @property string|null $birthday
 * @property string|null $info
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property string|null $last_action
 *
 * @property TaskMessages[] $taskMessages
 * @property TaskMessages[] $taskMessages0
 * @property TaskResponses[] $taskResponses
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UserCategories[] $userCategories
 * @property Categories[] $categories
 * @property UserFavourites[] $userFavourites
 * @property UserFavourites[] $userFavourites0
 * @property Users[] $favourites
 * @property Users[] $favoredBies
 * @property UserPortfolios[] $userPortfolios
 * @property UserSettings[] $userSettings
 * @property UserStats[] $userStats
 * @property Files $avatarFile
 * @property Cities $city
 */
class Users extends \yii\db\ActiveRecord
{
    public $feedbacks;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time', 'birthday', 'last_action'], 'safe'],
            [['email', 'password', 'name', 'city_id'], 'required'],
            [['city_id', 'avatar_file_id'], 'integer'],
            [['info'], 'string'],
            [['email', 'password', 'name', 'phone', 'skype', 'telegram'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['avatar_file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['avatar_file_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
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
            'email' => 'Email',
            'password' => 'Password',
            'name' => 'Name',
            'city_id' => 'City ID',
            'avatar_file_id' => 'Avatar File ID',
            'birthday' => 'Birthday',
            'info' => 'Info',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'last_action' => 'Last Action',
        ];
    }

    /**
     * Gets query for [[TaskMessages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskMessages()
    {
        return $this->hasMany(TaskMessages::className(), ['from_id' => 'id']);
    }

    /**
     * Gets query for [[TaskMessages0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskMessages0()
    {
        return $this->hasMany(TaskMessages::className(), ['to_id' => 'id']);
    }

    /**
     * Gets query for [[TaskResponses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskResponses()
    {
        return $this->hasMany(TaskResponses::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['contractor_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategories::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id'])->viaTable('user_categories', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserFavourites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFavourites()
    {
        return $this->hasMany(UserFavourites::className(), ['favored_by_id' => 'id']);
    }

    /**
     * Gets query for [[UserFavourites0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFavourites0()
    {
        return $this->hasMany(UserFavourites::className(), ['favourite_id' => 'id']);
    }

    /**
     * Gets query for [[Favourites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavourites()
    {
        return $this->hasMany(Users::className(), ['id' => 'favourite_id'])->viaTable('user_favourites', ['favored_by_id' => 'id']);
    }

    /**
     * Gets query for [[FavoredBies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoredBies()
    {
        return $this->hasMany(Users::className(), ['id' => 'favored_by_id'])->viaTable('user_favourites', ['favourite_id' => 'id']);
    }

    /**
     * Gets query for [[UserPortfolios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserPortfolios()
    {
        return $this->hasMany(UserPortfolios::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserSettings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSettings()
    {
        return $this->hasMany(UserSettings::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserStats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserStats()
    {
        return $this->hasMany(UserStats::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[AvatarFile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvatarFile()
    {
        return $this->hasOne(Files::className(), ['id' => 'avatar_file_id']);
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
}
