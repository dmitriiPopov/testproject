<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\models\User;

/* @var $this yii\web\View */
/* @var $formModel backend\models\user\UserForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($formModel, 'username')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'password')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'email')->textInput(['maxlength' => true]) ?>

    <?php

        if (in_array($formModel->scenario, [$formModel::SCENARIO_UPDATE])){

            $userStatus   = $formModel->status;
            $itemsActive  = array(User::STATUS_ACTIVE  => Yii::t('app', 'Active'),  User::STATUS_DELETED => Yii::t('app', 'Deleted'));
            $itemsDeleted = array(User::STATUS_DELETED => Yii::t('app', 'Deleted'), User::STATUS_ACTIVE  => Yii::t('app', 'Active'));

            if($userStatus === User::STATUS_ACTIVE){
                echo $form->field($formModel, 'status')->dropDownList($itemsActive);
            }else{
                echo $form->field($formModel, 'status')->dropDownList($itemsDeleted);
            }
        }

     ?>

    <?php //= $form->field($model, 'created_at')->textInput() ?>

    <?php //= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($formModel->model->isNewRecord ? 'Create' : 'Update', ['class' => $formModel->model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
