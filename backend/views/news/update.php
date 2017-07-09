<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $formModel backend\models\news\NewsForm */

$this->title = 'Update News: ' . $formModel->title;
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $formModel->title, 'url' => ['view', 'id' => $formModel->model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="news-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'formModel' => $formModel,
    ]) ?>

</div>
