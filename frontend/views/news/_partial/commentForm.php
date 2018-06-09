<?php

/*
 * @var $article
 * @var $commentForm
 * @var $commentScenario
 * @var $commentId
 */

use yii\helpers\Html;
use frontend\components\forms\CommentForm;

?>

<?php $form = \yii\widgets\ActiveForm::begin([
    'action'  => [
        //action in CommentsController (create or update)
        'comments/'.$commentScenario,
        //article id
        'articleId' => $article->id,
        //comment id
        'id'        => $commentId ? $commentId : null,
    ],
    'options' => [
        'class'           => 'form-horizontal contact-form',
        'role'            => 'form',
        'data-comment-id' => $commentId ? $commentId : null,
    ],
    'id'      => 'commentForm',
]) ?>

<?= $form->field($commentForm, 'name')->textInput(['placeholder' => 'Name'])->label(false); ?>

<?= $form->field($commentForm, 'content')->textarea(['placeholder' => 'Message'])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton( $commentScenario == CommentForm::SCENARIO_CREATE ? 'Оставить комментарий' : 'Обновить комментарий',
            [
                'class' => $commentScenario == CommentForm::SCENARIO_CREATE  ? 'btn btn-success' : 'btn btn-primary'
            ])
        ?>
    </div>

<?php \yii\widgets\ActiveForm::end(); ?>