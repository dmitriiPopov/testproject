<?php

use yii\widgets\ListView;

/**
 * @var $this                 yii\web\View
 * @var $dataProvider         yii\data\ActiveDataProvider
 * @var $categories           common\models\Category[]
 * @var $tags                 common\models\Tags[]
 * @var $selectedCategory     common\models\Category
 * @var $selectedTagsArray    common\models\Tags []
 * @var $selectedTagsIdArray  integer []
 */

$this->title = 'My Yii Application';

?>

<!-- Header BEGIN -->
<?php
    //check selected category
    if (isset($selectedCategory)) { ?>
        <h1 class="page-header text-justify">News from category "<?= $selectedCategory->title; ?>"</h1><?php
    } elseif (!empty($selectedTags)) {
        $str = null;
        foreach ($selectedTags as $tag) {

            $str .= $tag->name.', ';
        } ?>
        <h1 class="page-header text-justify">News with tag "<?= $str; ?>"</h1><?php
    } else { ?>
        <h1 class="page-header text-justify">News</h1><?php
    }
?>
<!-- Header END -->


<!-- List of news BEGIN -->
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'summary'      => false,
    'itemView'     => '_partial/newsList',
    'options'      => [
        'class' => 'text-center col-md-9',
    ],
    //pagination options
    'pager'        => [
        'nextPageLabel'  => 'Next',
        'prevPageLabel'  => 'Prev',
        'maxButtonCount' => 3,
        'options'        => [
            'class' => 'pagination',
        ],
    ],
]); ?>
<!-- List of news END -->


<!-- Lists of categories and tags BEGIN -->
<?= $this->render('_partial/newsHeader', [
    'categories'          => $categories,
    'tags'                => $tags,
    'selectedCategory'    => $selectedCategory,
    'selectedTagsArray'   => $selectedTagsArray,
    'selectedTagsIdArray' => $selectedTagsIdArray,
]); ?>
<!-- Lists of categories and tags END -->


