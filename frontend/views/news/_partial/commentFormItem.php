<?php

/*
 * @var $article
 * @var $commentForm \frontend\components\forms\CommentForm
 */

use yii\helpers\Html;

?>

<?php $form = \yii\widgets\ActiveForm::begin([
    'action'  => [
        //action in CommentsController (create or update)
        'comments/'.$commentForm->getScenario(),
        //article id
        'articleId' => $article->id,
    ],
    'options' => [
        'class'     => 'form-horizontal contact-form',
        'role'      => 'form',
    ],
    'id'      => 'commentForm',
]) ?>

<?= $form->field($commentForm, 'name')->textInput(['placeholder' => 'Name', 'value' => isset($_SESSION['name']) ? $_SESSION['name'] : ''])->label(false); ?>

<?= $form->field($commentForm, 'content')->textarea(['placeholder' => 'Message'])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Оставить комментарий', ['id' => 'buttonForm','class' => 'btn btn-success']); ?>
    </div>

<?php \yii\widgets\ActiveForm::end(); ?>