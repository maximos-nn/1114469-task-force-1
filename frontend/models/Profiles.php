<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property int $user_id
 * @property string $creation_time
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
 * @property ProfileCategories[] $profileCategories
 * @property Categories[] $categories
 * @property ProfileFavourites[] $profileFavourites
 * @property ProfileFavourites[] $profileFavourites0
 * @property Profiles[] $favourites
 * @property Profiles[] $favoredBies
 * @property ProfilePortfolios[] $profilePortfolios
 * @property ProfileSettings[] $profileSettings
 * @property ProfileStats[] $profileStats
 * @property Cities $city
 * @property Files $avatarFile
 * @property Users $user
 * @property TaskResponses[] $taskResponses
 * @property Tasks[] $tasks
 */
class Profiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'city_id'], 'required'],
            [['user_id', 'city_id', 'avatar_file_id'], 'integer'],
            [['creation_time', 'birthday', 'last_action'], 'safe'],
            [['info'], 'string'],
            [['name', 'phone', 'skype', 'telegram'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['avatar_file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['avatar_file_id' => 'id']],
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
            'creation_time' => 'Creation Time',
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
     * Gets query for [[ProfileCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfileCategories()
    {
        return $this->hasMany(ProfileCategories::className(), ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id'])->viaTable('profile_categories', ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[ProfileFavourites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfileFavourites()
    {
        return $this->hasMany(ProfileFavourites::className(), ['favored_by_id' => 'id']);
    }

    /**
     * Gets query for [[ProfileFavourites0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfileFavourites0()
    {
        return $this->hasMany(ProfileFavourites::className(), ['favourite_id' => 'id']);
    }

    /**
     * Gets query for [[Favourites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavourites()
    {
        return $this->hasMany(Profiles::className(), ['id' => 'favourite_id'])->viaTable('profile_favourites', ['favored_by_id' => 'id']);
    }

    /**
     * Gets query for [[FavoredBies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoredBies()
    {
        return $this->hasMany(Profiles::className(), ['id' => 'favored_by_id'])->viaTable('profile_favourites', ['favourite_id' => 'id']);
    }

    /**
     * Gets query for [[ProfilePortfolios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfilePortfolios()
    {
        return $this->hasMany(ProfilePortfolios::className(), ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[ProfileSettings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfileSettings()
    {
        return $this->hasMany(ProfileSettings::className(), ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[ProfileStats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfileStats()
    {
        return $this->hasMany(ProfileStats::className(), ['profile_id' => 'id']);
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
     * Gets query for [[AvatarFile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvatarFile()
    {
        return $this->hasOne(Files::className(), ['id' => 'avatar_file_id']);
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

    /**
     * Gets query for [[TaskResponses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskResponses()
    {
        return $this->hasMany(TaskResponses::className(), ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['profile_id' => 'id']);
    }
}
