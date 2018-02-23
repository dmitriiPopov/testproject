<?php

namespace backend\tests\unit;

use backend\models\news\NewsForm;
use common\fixtures\NewsFixture;
use common\fixtures\NewsTagsFixture;
use common\fixtures\TagsFixture;


/**
 * News form test
 */
class NewsFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'news'     => [
                'class'    => NewsFixture::className(),
                'dataFile' => codecept_data_dir() . 'news_data.php'
            ],
            'tags'     => [
                'class'    => TagsFixture::className(),
                'dataFile' => codecept_data_dir() . 'tags_data.php'
            ],
//            'tagsNews' => [
//                'class'    => NewsTagsFixture::className(),
//                'dataFile' => codecept_data_dir() . 'news_tags_data.php'
//            ]
        ]);
    }

    public function testStatusValidation()
    {
        //create news form
        $formModel = new NewsForm(['scenario' => NewsForm::SCENARIO_CREATE]);
        //change attribute
        $formModel->setAttributes([
            'status' => 'wrong_status',
        ]);
        //expect wrong message
        expect('Validation status fault', $formModel->save())->false();
    }

    public function testTitleValidation()
    {
        //create news form
        $formModel = new NewsForm(['scenario' => NewsForm::SCENARIO_CREATE]);
        //change attribute
        $formModel->setAttributes([
            'title' => '',
        ]);
        //expect wrong message
        expect('Validation title fault', $formModel->save())->false();
    }

    public function testCategoryValidation()
    {
        //create news form
        $formModel = new NewsForm(['scenario' => NewsForm::SCENARIO_CREATE]);
        //change attribute
        $formModel->setAttributes([
            'category_id' => '',
        ]);
        //expect wrong message
        expect('Validation category fault', $formModel->save())->false();
    }

    public function testDescriptionValidation()
    {
        //create news form
        $formModel = new NewsForm(['scenario' => NewsForm::SCENARIO_CREATE]);
        //change attribute
        $formModel->setAttributes([
            'description' => '',
        ]);
        //expect wrong message
        expect('Validation description fault', $formModel->save())->false();
    }

    public function testTagsValidation()
    {
        //create news form
        $formModel = new NewsForm(['scenario' => NewsForm::SCENARIO_CREATE]);
        //change attribute
        $formModel->setAttributes([
            'tagsArray' => ['Tag1','Tag2','Tag3','Tag4'],
        ]);
        //expect wrong message
        expect('Validation tags fault', $formModel->validate())->true();
    }
}