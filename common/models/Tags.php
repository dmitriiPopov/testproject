<?php

namespace common\models;

use Yii;
use common\components\behaviors\CreatedAtUpdatedAtBehavior;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $name
 * @property integer $enabled
 * @property integer $display
 * @property string $created_at
 * @property string $updated_at
 *
 * @property NewsTags[] $newsTags
 */
class Tags extends \yii\db\ActiveRecord
{
    const ENABLED_ON  = 1;
    const ENABLED_OFF = 0;

    const DISPLAY_ON  = 1;
    const DISPLAY_OFF = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enabled', 'display'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 127],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'enabled' => 'Enabled',
            'display' => 'Display',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'createdAtUpdatedAtBehavior' => [
                'class' => CreatedAtUpdatedAtBehavior::className(),
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsTags()
    {
        return $this->hasMany(NewsTags::className(), ['tag_id' => 'id']);
    }

    /**
     * @param bool $insert
     */
    public function beforeSave($insert)
    {
        if ($this->enabled == self::ENABLED_ON) {
            $this->display = self::DISPLAY_ON;
        } else {
            $this->display = self::DISPLAY_OFF;
        }

        return true;
    }
}
