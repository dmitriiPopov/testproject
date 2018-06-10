<?php

use yii\helpers\Html;

/**
 * @var $model \common\models\Comment *
 */
?>

<!-- Comments block BEGIN -->
<div class="list-group text-justify">
    <div id="comment-<?= $model->id; ?>" class="col-lg-12" style="background: #ffffff; box-shadow: 0 0 10px rgba(0,0,0,0.5); padding: 10px; margin-bottom: 20px;">

        <div class="col-lg-1" style="display: inline-block; vertical-align: top">
            <?= Html::img(common\models\User::findOne($model->user_id)->getImageFileLink(), ['width'=>'40', 'height'=>'40', 'class'=>'img-circle']) ?>
        </div>

        <div class="col-lg-10" style="display: inline-block">
            <span style="color: #337ab7; font-size: large"><?= $model->name.","; ?></span>
            <span style="font-size: small; color: #4c4c4c;"><?= $model->updated_at ? $model->updated_at : $model->created_at; ?></span>
            <div class="content-container"><?= $model->content; ?></div>
        </div>
        <!-- Check user for buttons delete and update-->
        <?php if (Yii::$app->user->id == $model->user_id) : ?>

            <div>

                <!-- update button-->
                <?= Html::button('', [
                    'class' => 'glyphicon glyphicon-pencil updateComment',
                    'style' => [
                        'background-color' => '#4CAF50', /* Green */
                        'border'           => 'none',
                        'color'            => 'white',
                        'border-radius'    => '2px',
                        'display'          => 'inline-block',
                        'padding'          => '5px',
                    ],
                    'data-id'   => $model->id,
                    //TODO: зачем ту писал id в alt?
                ]) ?>
                <!-- delete button-->
                <?= Html::button('', [
                    'class' => 'glyphicon glyphicon-trash',
                    'style' => [
                        'background-color' => '#4CAF50', /* Green */
                        'border'           => 'none',
                        'color'            => 'white',
                        'border-radius'    => '2px',
                        'display'          => 'inline-block',
                        'padding'          => '5px',
                    ],
                    // TODO: зачем эта data?
                    'data'  => [
//                        'confirm' => 'Are you sure you want to delete this item?',
                        'method'  => 'post',
                    ],
                ]) ?>

            </div>

        <?php endif; ?>
        <!-- end buttons delete and update -->
    </div>
</div>
<!-- Comments block END-->