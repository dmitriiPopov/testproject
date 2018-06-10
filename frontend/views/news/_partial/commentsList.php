<?php

/**
 * @var $comments yii\data\ActiveDataProvider
 */

use yii\widgets\Pjax;
use yii\widgets\ListView;

?>

<?php
//TODO: зачем ты используешь PJAX? мы же договорились его не использовать. Нельзя использовать это не разобравшись с ajax
//TODO: убрал PJAX
?>
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
