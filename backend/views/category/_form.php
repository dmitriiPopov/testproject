<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $formModel backend\models\category\CategoryForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($formModel, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'enabled')->checkbox() ?>

    <?= $form->field($formModel, 'display')->checkbox() ?>

    <?php //= $form->field($formModel, 'created_at')->textInput() ?>

    <?php //= $form->field($formModel, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($formModel->model->isNewRecord ? 'Create' : 'Update', ['class' => $formModel->model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
//JS for enabled and display checkboxes
/*$script = <<< JS

    setInterval(function() {
      //if enabled is check
      if($('#enabled').is(':checked')){
        //display checkbox is enable
        $('#display').attr('disabled', false);
      }else{
        //display checkbox is disable and unchecked
        $('#display').attr('disabled', true).attr('checked', false);
      }
    }, 10);
JS;
$this->registerJs("

.........

");*/
?>