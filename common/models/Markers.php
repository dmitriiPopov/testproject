<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "markers".
 *
 * @property int $id
 * @property double $latitude
 * @property double $longitude
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User[] $users
 */
class Markers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'markers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['latitude', 'longitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        //TODO: тут  hasOne так как у каждого пользователя будет уникальная точка на карте (так как ты для каждого пользователя создаешь новую точку)
        return $this->hasMany(User::className(), ['marker_id' => 'id']);
    }
}
