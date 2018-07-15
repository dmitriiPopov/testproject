<?php

/**
 * @var $commentForm \frontend\components\forms\CommentForm
 * @var string $userName
 */

use yii\helpers\Html;

?>

<?php $form = \yii\widgets\ActiveForm::begin([
    'action'  => [
        //action in CommentsController (create or update)
        ($commentForm->scenario == \frontend\components\forms\CommentForm::SCENARIO_UPDATE)
            ? 'comments/update'
            : 'comments/create',
        //article id
        'articleId' => $commentForm->articleId,
    ],
    'options' => [
        'class'     => 'form-horizontal contact-form',
        'role'      => 'form',
    ],
    'id'      => 'commentForm',
]) ?>

<?= $form->field($commentForm, 'id', [
    'options' => [
        'style' => 'display: none;'
    ],
])->hiddenInput([
        'value' => $commentForm->id,
])->label(false); ?>

<?= $form->field($commentForm, 'name')->textInput([
        'placeholder' => 'Name',
        'maxlength'   => 20,
    ])->label(false); ?>

<?= $form->field($commentForm, 'content')->textarea([
        'placeholder' => 'Message',
        'maxlength'   => 200,
])->label(false); ?>

    <div class="form-group">
        <?= ($commentForm->scenario == \frontend\components\forms\CommentForm::SCENARIO_UPDATE)
            ? Html::submitButton('Изменить комментарий', ['id' => 'buttonForm','class' => 'btn btn-primary'])
            : Html::submitButton('Оставить комментарий', ['id' => 'buttonForm','class' => 'btn btn-success']);
        ?>
    </div>

<?php \yii\widgets\ActiveForm::end(); ?>