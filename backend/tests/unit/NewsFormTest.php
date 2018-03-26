<?php

namespace backend\tests\unit;

use backend\models\news\NewsForm;

use common\fixtures\CategoryFixture;
use common\fixtures\NewsFixture;
use common\fixtures\NewsTagsFixture;
use common\fixtures\TagsFixture;
use common\models\News;



/**
 * News form test
 *
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
    }

    /**
     * Validate Article's creation
     */
    public function testCreateArticle()
    {
        // СОЗДАНИЕ новости
        $formModel = new NewsForm(['scenario' => NewsForm::SCENARIO_CREATE]);
        $formModel->setModel(new News());

        //ЭМУЛЯЦИЯ САБМИТА ДАННЫХ ИЗ ФОРМЫ
        $requestFromHtmlForm = [
            'category_id' => 1,
            'title'       => '',
            'imagefile'   => '',
            'description' => 'sadasdasd',
            'content'     => 'adasdasdasd',
            'status'      => News::STATUS_NEW,
            'enabled'     => News::ENABLED_ON,
            // превышающее допустимое количество тегов
            'tagsArray'   => ['Tag1','Tag2','Tag3','Tag4','Tag5','Tag6'],
        ];

        //ЭМУЛЯЦИЯ САБМИТА ДАННЫХ ИЗ ФОРМЫ
        $formModel->setAttributes($requestFromHtmlForm);

        // не должно сохраниться, так как title - ПУСТОЙ!!!
        expect('News won\'t be created ', $formModel->save())->false();

        // задаем навазине новости
        $formModel->title     = 'Теперь название новости не пустое';

        // не должно сохраниться, так как превышено допустимое количество тегов!!!
        expect('News won\'t be created ', $formModel->save())->false();

        // задаем допустимое количество тегов
        $formModel->tagsArray = ['Tag1','Tag2','Tag3'];

        // валидируем и сохраняем
        $isSaved = $formModel->save();

        // данные мы в форму задали валидные и новость должна провалидироваться и успешно сохраниться!!!
        expect(sprintf('Form errors: %s', json_encode($formModel->errors)), $isSaved)->true();
    }

    /**
     * Validate Article's updating
     */
    public function testUpdateArticle()
    {
        //find Article with id=1
        $model     = News::findOne(1);
        $formModel = new NewsForm(['scenario' => NewsForm::SCENARIO_UPDATE]);
        $formModel->setModel($model, true);

        //CHECK DATA
        //check title
        $this->assertEquals('Test Article 1', $formModel->title);
        //check category_id
        $this->assertEquals(1, $formModel->category_id);
        //check description
        $this->assertEquals('Description of Article 1', $formModel->description);

        //CHANGE DATA to FALSE DATA
        //change title and check
        $formModel->title = "";
        $this->assertFalse($formModel->save());

        //change category_id and check
        $formModel->category_id = 3;
        $formModel->title       = "Test Article 1 Update";
        $this->assertFalse($formModel->save());

        //change description and check
        $formModel->description = "";
        $formModel->category_id = 2;
        $this->assertFalse($formModel->save());

        //set true description
        $formModel->description = "Description of Article 1 Update";
        //check saving, it's must be TRUE
        $this->assertTrue($formModel->save());
    }
}