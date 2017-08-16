<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
use common\models\Category;
use common\models\News;
use kartik\datetime\DateTimePicker;

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

    <?= $form->field($formModel, 'content')->widget(Redactor::className()) ?>

    <?= $form->field($formModel, 'status')->dropDownList(News::getStatuses(), ['prompt' => 'Select status']) ?>

    <?= $form->field($formModel, 'enabled')->checkbox() ?>

    <?php //= $form->field($formModel, 'display')->checkbox() ?>

    <?php //$form->field($model, 'created_at')->textInput() ?>

    <?php //$form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($formModel, 'public_at')->widget(DateTimePicker::classname(), [
        'options'       => [
            'placeholder'    => 'Enter event time ...',

        ],
        'pluginOptions' => [
            'autoclose'      => true,
            'todayHighlight' => true,
        ]
    ]); ?>

    <?php //$form->field($model, 'published_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($formModel->model->isNewRecord ? 'Create' : 'Update', ['class' => $formModel->model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
//JS for enabled and display checkboxes
//$script = <<< JS
//
//    setInterval(function() {
//      //if enabled is check
//      if($('#enabled').is(':checked')){
//        //display checkbox is enable
//        $('#display').attr('disabled', false);
//      }else{
//        //display checkbox is disable and unchecked
//        $('#display').attr('disabled', true).attr('checked', false);
//      }
//    }, 10);
//JS;
//$this->registerJs($script);
?>