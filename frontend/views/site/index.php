<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/**
 * @var $this                 yii\web\View
 * @var $dataProvider         yii\data\ActiveDataProvider
 * @var $categories           common\models\Category[]
 * @var $tags                 common\models\Tags[]
 * @var $selectedCategory     common\models\Category
 * @var $selectedTagsArray    common\models\Tags []
 * @var $selectedTagsIdArray  integer []
 * @var $searchQuery          string
 */

$this->title = 'My Yii Application';

?>

<!-- Header BEGIN -->
<?php
    //check selected category
    if (isset($selectedCategory)) { ?>
        <h1 class="page-header text-justify">News from category "<?= $selectedCategory->title; ?>"</h1><?php
    } else { ?>
        <h1 class="page-header text-justify">News</h1><?php
    }
?>
<!-- Header END -->


<!-- Content BEGIN -->
<div class="col-md-9">

    <!-- Search BEGIN -->
    <?= Html::beginForm(['site/index']+
        array_merge(
            ['categoryId' => !empty($selectedCategory) ? $selectedCategory->id : ''],
            ['selectedTags' => !empty($selectedTagsIdArray) ? implode('+', $selectedTagsIdArray) : '']
        ),
        'get',
        ['class' => 'form-inline']); ?>
        <?= Html::input('text', 'searchQuery', $searchQuery, ['class' => 'form-control', 'style' => 'width: 90%', 'placeholder' => 'Search']) ?>
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::endForm() ?>
    <!-- Search END -->


    <!-- List of news BEGIN -->
    <?= ListView::widget([
        'dataProvider'   => $dataProvider,
        'summary'        => $searchQuery ? '<div style="padding-bottom: 5px;"><b>Найдено совпадений: {totalCount}</b></div>' : false,
//        'summaryOptions' => [
//            'tag'   => 'div',
//            //'class' => 'summary',
//            'style' => 'text-align: left;'
//        ],
        'itemView'       => '_partial/newsList',
        'options'        => [
            'class' => 'text-center',
            'style' => 'padding-top: 20px',
        ],
        'emptyText'      => $searchQuery ? '<p>По Вашему запросу ничего не найдено</p>' : '<p>Список пуст</p>',
        //pagination options
        'pager'          => [
            'nextPageLabel'  => 'Next',
            'prevPageLabel'  => 'Prev',
            'maxButtonCount' => 3,
            'options'        => [
                'class' => 'pagination',
            ],
        ],
    ]); ?>
    <!-- List of news END -->

</div>
<!-- Content END -->

<!-- Lists of categories and tags BEGIN -->
<?= $this->render('_partial/newsHeader', [
    'categories'          => $categories,
    'tags'                => $tags,
    'selectedCategory'    => $selectedCategory,
    'selectedTagsArray'   => $selectedTagsArray,
    'selectedTagsIdArray' => $selectedTagsIdArray,
]); ?>
<!-- Lists of categories and tags END -->


