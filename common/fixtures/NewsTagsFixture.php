<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class NewsTagsFixture extends ActiveFixture
{
    public $modelClass = 'common\models\NewsTags';
    public $depends    = ['common\fixtures\NewsFixture', 'common\fixtures\TagsFixture'];
}