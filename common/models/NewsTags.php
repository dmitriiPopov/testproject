<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news_tags".
 *
 * @property integer $id
 * @property integer $news_id
 * @property integer $tag_id
 * @property string $created_at
 *
 * @property News $news
 * @property Tags $tag
 */
class NewsTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_id', 'tag_id'], 'required'],
            [['news_id', 'tag_id'], 'integer'],
            [['created_at'], 'safe'],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'News ID',
            'tag_id' => 'Tag ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tags::className(), ['id' => 'tag_id']);
    }

    /**
     * Connect list of selected tags with selected one News record
     * @param News  $news     One News record
     * @param array $tagsIds  List of ids of Tags records
     *
     * @return boolean
     *
     * TODO: использовать такой формат добавления тега к новости вместо   News->createAddTag
     * TODO: мы же как-бы работаем на уровне объектов )))
     *
     * TODO: не используешь отступы согласно PSR
     * TODO: не сокращай названия переменных так что это становится не понятно, например "array" лучше чем "arr". Если название переменной короткое  пончтно - ОК. Если короткое, но неочвидно - НЕ ок - делай длиннее, но понятнее.
     * TODO: используй [] вместо array(
     */
    public static function addTagsToNewsByTagsIds(News $news, array $tagsIds)
    {

    }
}
