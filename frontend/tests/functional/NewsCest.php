<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

use common\fixtures\CategoryFixture;
use common\fixtures\NewsFixture;
use common\fixtures\NewsTagsFixture;
use common\fixtures\TagsFixture;

class NewsCest
{
    function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'category'  => [
                'class'    => CategoryFixture::className(),
                'dataFile' => codecept_data_dir() . 'category_data.php'
            ],
            'tags'      => [
                'class'    => TagsFixture::className(),
                'dataFile' => codecept_data_dir() . 'tags_data.php'
            ],
            'news'      => [
                'class'    => NewsFixture::className(),
                'dataFile' => codecept_data_dir() . 'news_data.php'
            ],
            'news_tags' => [
                'class'    => NewsTagsFixture::className(),
                'dataFile' => codecept_data_dir() . 'news_tags_data.php'
            ],
        ]);

        $I->amOnPage(\Yii::$app->homeUrl);
    }

    public function checkAllNews(FunctionalTester $I)
    {
        $I->see('News');
        $I->see('Categories');
        $I->see('Tags');

        $I->see('All', '.btn-success');
        $I->see('All', '.list-group-item-success');
        //must see Article 1, Article 2 and Article 3
        $I->see('Test Article 1', '.list-group-item-heading');
        $I->see('Test Article 2', '.list-group-item-heading');
        $I->see('Test Article 3', '.list-group-item-heading');
    }

    public function checkCategoryNews(FunctionalTester $I)
    {
        //choice category 1
        $I->click('Категория 1', '.list-group-item');
        $I->dontSee('All', '.list-group-item-success');
        //must see only Article 1
        $I->see('Test Article 1', '.list-group-item-heading');
        $I->dontSee('Test Article 2', '.list-group-item-heading');
    }

    public function checkTagsNews(FunctionalTester $I)
    {
        //choice tag1
        $I->click('Tag1', '.btn');
        $I->dontSee('All', '.btn-success');
        //must see Article 1 and Article 2
        $I->see('Test Article 1', '.list-group-item-heading');
        $I->see('Test Article 2', '.list-group-item-heading');
        //choice tag2
        $I->click('Tag2', '.btn');
        $I->dontSee('All', '.btn-success');
        //must see only Article 1
        $I->see('Test Article 1', '.list-group-item-heading');
        $I->dontSee('Test Article 2', '.list-group-item-heading');
    }

    public function checkCategoryTagsNews(FunctionalTester $I)
    {
        //choice tag3
        $I->click('Tag3', '.btn');
        //choice category 1
        $I->click('Категория 3', '.list-group-item');
        //must see only Article 3
        $I->see('Test Article 3', '.list-group-item-heading');
        $I->dontSee('Test Article 1', '.list-group-item-heading');
        $I->dontSee('Test Article 2', '.list-group-item-heading');
    }

    public function checkViewArticle(FunctionalTester $I)
    {
        $I->amGoingTo('View content article 3');
        //click article 3 on main page
        $I->click('Test Article 3', '.list-group-item');
        $I->expect('View content, tags, category of article 3');
        //check url
        $I->seeInCurrentUrl('/article/3');
        //check content
        $I->see('Content of Article 3');
        $I->dontSee('Some Invalid Text');
        //check category
        $I->see('Категория 3', '.list-group-item-success');
        $I->dontSee('Категория 2', '.list-group-item-success');
        //check Tag
        $I->see('Tag3', '.btn-success');
        $I->dontSee('Tag1', '.btn-success');
    }
}