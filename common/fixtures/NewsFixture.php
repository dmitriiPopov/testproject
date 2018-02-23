<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class NewsFixture extends ActiveFixture
{
    public $modelClass = 'common\models\News';
    public $depends    = ['common\fixtures\CategoryFixture'];
}