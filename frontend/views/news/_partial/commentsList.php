<?php

/*
 * @var $comments yii\data\ActiveDataProvider
 */

use yii\widgets\Pjax;
use yii\widgets\ListView;

?>

<?php Pjax::begin(['enablePushState' => true, 'enableReplaceState' => false]); ?>
    <?= ListView::widget([
        'dataProvider' => $comments,
        'summary'      => false,
        'itemView'     => 'commentItem',
        'options'      => [
            'class' => 'text-center',
        ],
        'emptyText' => '<p>Комментарии отсутствуют. Вы можете стать первым.</p>',
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

<?php Pjax::end(); ?>