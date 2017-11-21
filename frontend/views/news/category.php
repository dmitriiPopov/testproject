<?php

use yii\widgets\ListView;

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $category common\models\Category
 * @var $categories common\models\Category[]
 * @var $tags common\models\Tags[]
 */

$this->title = $category->title;
$this->params['breadcrumbs'][] = $this->title;

?>

<!-- Header BEGIN -->
<h1 class="page-header text-justify" style="color: #333; margin-top: 0;">News from category "<?= $category->title; ?>"</h1>
<!-- Header END -->

<!-- List of news BEGIN -->
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'summary'      => false,
    'itemView'     => '../site/_partial/newsList',
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


<!-- List of categories BEGIN -->
<?= $this->render('../site/_partial/newsHeader', [
    'categories'       => $categories,
    'selectedCategory' => $category,
    'tags'             => $tags,
]); ?>
<!-- List of categories END -->
