<?php

/**
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

<?
//TODO: еще нашел ошибку:
1) создаю комментарий
2) и потом сразу его редактирую
3) редактирование не проходит (видимо не передается пользователь - 403 ошибка от comments/update)

// TODO: подойди к решению проблемы комплесно:
//TODO: 1) тебе нужно в эту форму добавить id новости И id пользователя и передавать их оба, когда создаешь или редактируешь комментарий
//TODO: 2) еще добавь сюда id комментария и будешь его оптравлять только при редактировании (НЕ data-id !!!)
//TODO: в этом случае у тебя  уменьшится размер js в твоем view.php И при отправке данных на сервер у тебя будут все данные в html-форме
?>

<?= $form->field($commentForm, 'name')->textInput(['placeholder' => 'Name', 'value' => isset($_SESSION['name']) ? $_SESSION['name'] : ''])->label(false); ?>

<?= $form->field($commentForm, 'content')->textarea(['placeholder' => 'Message'])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Оставить комментарий', ['id' => 'buttonForm','class' => 'btn btn-success']); ?>
    </div>

<?php \yii\widgets\ActiveForm::end(); ?>