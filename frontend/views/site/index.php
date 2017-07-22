<?php

use yii\widgets\ListView;

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $categories common\models\Category
 */

$this->title = 'My Yii Application';

?>

<!-- Header BEGIN -->
<h1 class="page-header text-justify">News</h1>
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


<!-- List of categories BEGIN -->
<?= $this->render('_partial/newsHeader', [
    'categories' => $categories,
]); ?>
<!-- List of categories END -->

