<?php

namespace common\models;

use Yii;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;

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
     */
    public static function addTagsToNewsByTagsIds(News $news, array $tagsIds)
    {
        if (is_array($tagsIds)) {
            //set tags similar to news
            $oldTags = ArrayHelper::map($news->tags, 'name', 'id');
            //var_dump($tagsIds);die;

            foreach ($tagsIds as $newTag) {
                //$tag = Tags::find()->andWhere(['name' => $newTag])->andWhere(['enabled' => Tags::ENABLED_ON])->one();
                //var_dump($tag);die;
                //check new tag in old_tags array
                if (isset($oldTags[$newTag]) && Tags::find()->andWhere(['name' => $newTag, 'enabled' => Tags::ENABLED_ON])->one()) {
                    //remove from old_tags array
                    unset($oldTags[$newTag]);
                } else {
                    //if newTag not found in Tags table
                    if (!$tag = Tags::find()->andWhere(['name' => $newTag])->one()) {
                        //create new tag
                        $tag          = new Tags();
                        //set name new tag
                        $tag->name    = $newTag;
                        $tag->enabled = Tags::ENABLED_ON;
                        //save new tag
                        if (!$tag->save()) {
                            return false;
                        }
                    }
                    //check instance
                    if ($tag instanceof Tags && $tag->enabled) {
                        //create new record in news_tags table
                        $newsTags          = new NewsTags();
                        //set params
                        $newsTags->news_id = $news->id;
                        $newsTags->tag_id  = $tag->id;
                        //save record
                        if (!$newsTags->save()) {
                            return false;
                        }
                    }
                }
            }
            //delete all records from News_tags table where not use old tags
            NewsTags::deleteAll(['and', ['news_id' => $news->id], ['tag_id' => $oldTags]]);
        }else{
            //delete all records belonging to the identifier from News_tags table
            NewsTags::deleteAll(['news_id' => $news->id]);
        }

        return true;
    }
}
