<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $formModel backend\models\tags\TagsForm */

$this->title = 'Update Tags: ' . $formModel->name;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $formModel->name, 'url' => ['view', 'id' => $formModel->model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tags-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'formModel' => $formModel,
    ]) ?>

</div>
