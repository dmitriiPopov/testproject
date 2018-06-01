<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $formModel backend\models\comments\CommentForm */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'id')->textInput() ?>

    <?php echo $form->field($formModel, 'user_id')->textInput([
            'value'    => \common\models\User::findOne($formModel->model->user_id)->username,
            'disabled' => true
    ]) ?>

    <?php echo $form->field($formModel, 'news_id')->textInput([
            'value'    => \common\models\News::findOne($formModel->model->news_id)->title,
            'disabled' => true
    ]) ?>

    <?= $form->field($formModel, 'name')->textInput() ?>

    <?= $form->field($formModel, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($formModel, 'enabled')->checkbox() ?>

    <?php //echo $form->field($model, 'created_at')->textInput() ?>

    <?php //echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
