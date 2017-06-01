<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $formModel backend\models\user\UserForm */

$this->title = 'Update User: ' . $formModel->model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $formModel->model->username, 'url' => ['view', 'id' => $formModel->model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'formModel' => $formModel,
    ]) ?>

</div>
