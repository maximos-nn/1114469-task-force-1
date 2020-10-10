<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $path
 *
 * @property TaskFiles[] $taskFiles
 * @property UserPortfolios[] $userPortfolios
 * @property Users[] $users
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path'], 'required'],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
        ];
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFiles::className(), ['file_id' => 'id']);
    }

    /**
     * Gets query for [[UserPortfolios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserPortfolios()
    {
        return $this->hasMany(UserPortfolios::className(), ['file_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['avatar_file_id' => 'id']);
    }
}
