<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

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

            <div class="col-lg-1" style="display: inline-block;">

                <!-- update button-->
                <?= Html::a('', ['news/view', 'id' => $model->news_id, 'commentId' => $model->id], [
                    'class' => 'glyphicon glyphicon-pencil',
                    'style' => [
                        'text-decoration' => 'none',
                    ],
                    'data'  => [
                        'confirm' => 'Are you sure you want to update this item?',
                        'method'  => 'post',
                    ],
                ]) ?>
                <!-- delete button-->
                <?= Html::a('', ['comments/delete', 'articleId' => $model->news_id, 'id' => $model->id], [
                    'class' => 'glyphicon glyphicon-trash',
                    'style' => [
                        'text-decoration' => 'none',
                    ],
                    'data'  => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method'  => 'post',
                    ],
                ]) ?>

            </div>

        <?php endif; ?>
        <!-- end buttons delete and update -->
    </div>
</div>
<!-- Comments block END-->