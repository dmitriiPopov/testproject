<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $formModel backend\models\news\NewsForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'imagefile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'category_id')->dropDownList(
        ArrayHelper::map(Category::find()->all(), 'id', 'title'),
        ['prompt'=>'Select Category']
    ) ?>

    <?= $form->field($formModel, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'content')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($formModel, 'status')->dropDownList([ 'new' => 'New', 'publicate' => 'Publicate', 'published' => 'Published' ], ['prompt' => 'Select status']) ?>

    <?= $form->field($formModel, 'enabled')->checkbox() ?>

    <?= $form->field($formModel, 'display')->checkbox() ?>

    <?php //$form->field($model, 'created_at')->textInput() ?>

    <?php //$form->field($model, 'updated_at')->textInput() ?>

    <?php //$form->field($model, 'public_at')->textInput() ?>

    <?php //$form->field($model, 'published_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($formModel->model->isNewRecord ? 'Create' : 'Update', ['class' => $formModel->model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
