<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\models\User;

/* @var $this yii\web\View */
/* @var $formModel backend\models\user\UserForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($formModel, 'username')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'password')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'email')->textInput(['maxlength' => true]) ?>

    <?php
        if(in_array($formModel->scenario, [$formModel::SCENARIO_UPDATE])){
           echo Html::img($formModel->model->getImageFileLink(), ['width'=>'120', 'height'=>'120', 'class'=>'img-circle']);
           //add button 'delete' if avatar aren't default
           if($formModel->model->imagefile && file_exists($formModel->model->getImageFileAbsolutePath())){
               echo ' '.Html::a(Yii::t('app', 'Delete'), ['avatardelete', 'id' => $formModel->model->id], [
                   'class' => 'btn btn-danger',
                   'data'  => [
                       'confirm' => 'Are you sure you want to remove this avatar?',
                       'method'  => 'post',
                   ],
                   'style' => [
                       //'vertical-align' => 'top',
                   ],
               ]);
           }
        }

    ?>

    <?= $form->field($formModel, 'avatar')->fileInput() ?>

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
