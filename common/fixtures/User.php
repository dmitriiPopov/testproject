<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

use common\models\AdminUser;

class User extends ActiveFixture
{
    public $modelClass = 'common\models\AdminUser';
}