<?php

/**
 * @var $comments yii\data\ActiveDataProvider
 */

use yii\widgets\Pjax;
use yii\widgets\ListView;

?>
    <?= ListView::widget([
        'dataProvider' => $comments,
        'summary'      => false,
        'itemView'     => 'commentItem',
        'options'      => [
            'class' => 'text-center',
        ],
        'emptyText' => '<p>No any comments here. You can be first.</p>',
        //pagination options
//        'pager'        => [
//            'nextPageLabel'  => '>',
//            'prevPageLabel'  => '<',
//            'maxButtonCount' => 3,
//            'options'        => [
//                'class' => 'pagination',
//            ],
//        ],
    ]); ?>
