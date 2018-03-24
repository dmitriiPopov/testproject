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
 * TODO: https://codeception.com/docs/05-UnitTests - полезная официальная документация
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
            //TODO: создаем записи в таблицах в порядке их приоритета. Вначале то, что нужно для связей, а уже после них записи со связями
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
     * //TODO: если хочешь првоерить сохранение новости с разными значениями (категория, тайтл и т.п. то проверяй сразу все - так это единый процесс СОЗДАНИЯ новости)
     * Validate Article creation
     */
    public function testCreateNews()
    {
        //TODO: ВАЖНО ---> заметь, что логика ниже взята по аналогии из \backend\controllers\NewsController::actionCreate(), так как ТЕСТ - это ЭМУЛЯЦИЯ реальной работы
        // СОЗДАНИЕ новости
        $formModel = new NewsForm(['scenario' => NewsForm::SCENARIO_CREATE]);
        $formModel->setModel(new News());

        //ЭМУЛЯЦИЯ САБМИТА ДАННЫХ ИЗ ФОРМЫ
        $requestFromHtmlForm = [
            'category_id' => 1,
            // TODO: вот пустой title (как у тебя было в твоих предыдущих тестах)
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

        //TODO: вот проверка пустой title (как у тебя было в твоих предыдущих тестах)
        // не должно сохраниться, так как title - ПУСТОЙ!!!
        expect('News won\'t be created ', $formModel->save())->false();

        // задаем навазине новости
        $formModel->title     = 'Теперь название новости не пустое';
        // задаем допустимое количество тегов
        $formModel->tagsArray = ['Tag1','Tag2','Tag3'];

        // валидируем и сохраняем
        $isSaved = $formModel->save();

        //TODO: а вот успешная операция в конце
        // данные мы в форму задали валидные и новость должна провалидироваться и успешно сохраниться!!!
        expect(sprintf('Form errors: %s', json_encode($formModel->errors)), $isSaved)->true();
    }
}