<?php

/*
 * @var $article
 * @var $commentForm
 * @var $commentScenario
 * @var $commentId
 */

use yii\helpers\Html;

?>

<?php $form = \yii\widgets\ActiveForm::begin([
    'action'  => [
        //action in CommentsController (create or update)
        // TODO: зачем передавать сюда переменную $commentScenario, когда у тебя уже сюда передан весь объект формы $commentForm, из которого ты можешь получить эту информацию?
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

<?= $form->field($commentForm, 'name')->textInput(['placeholder' => 'Name', 'value' => isset($_SESSION['name']) ? $_SESSION['name'] : ''])->label(false); ?>

<?= $form->field($commentForm, 'content')->textarea(['placeholder' => 'Message'])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Оставить комментарий', ['id' => 'buttonForm','class' => 'btn btn-success']); ?>
    </div>

<?php \yii\widgets\ActiveForm::end(); ?>