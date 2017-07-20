<?php

use yii\widgets\ListView;

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $category common\models\Category
 * @var $categories common\models\Category
 */

$this->title = $category->title;
$this->params['breadcrumbs'][] = $this->title;

?>

<!-- List of news -->
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

<!-- List of categories -->
<?= $this->render('../site/_partial/newsHeader', [
    'categories'       => $categories,
    'selectedCategory' => $category,
]); ?>
