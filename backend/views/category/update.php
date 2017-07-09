<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $formModel backend\models\category\CategoryForm */

$this->title = 'Update Category: ' . $formModel->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $formModel->title, 'url' => ['view', 'id' => $formModel->model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'formModel' => $formModel,
    ]) ?>

</div>
