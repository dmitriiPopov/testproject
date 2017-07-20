<?php

use yii\widgets\ListView;

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $categories common\models\Category
 */

$this->title = 'My Yii Application';

?>

<!-- List of news -->
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

<!-- List of categories -->
<?= $this->render('_partial/newsHeader', [
    'categories'       => $categories,
]); ?>