<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "profile_favourites".
 *
 * @property int $id
 * @property int $favored_by_id
 * @property int $favourite_id
 *
 * @property Profiles $favoredBy
 * @property Profiles $favourite
 */
class ProfileFavourites extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_favourites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['favored_by_id', 'favourite_id'], 'required'],
            [['favored_by_id', 'favourite_id'], 'integer'],
            [['favored_by_id', 'favourite_id'], 'unique', 'targetAttribute' => ['favored_by_id', 'favourite_id']],
            [['favored_by_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::className(), 'targetAttribute' => ['favored_by_id' => 'id']],
            [['favourite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::className(), 'targetAttribute' => ['favourite_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'favored_by_id' => 'Favored By ID',
            'favourite_id' => 'Favourite ID',
        ];
    }

    /**
     * Gets query for [[FavoredBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoredBy()
    {
        return $this->hasOne(Profiles::className(), ['id' => 'favored_by_id']);
    }

    /**
     * Gets query for [[Favourite]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavourite()
    {
        return $this->hasOne(Profiles::className(), ['id' => 'favourite_id']);
    }
}
