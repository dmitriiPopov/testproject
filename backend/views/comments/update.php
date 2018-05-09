<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $formModel backend\models\comments\CommentForm */

$this->title = 'Update Comment: #'.$formModel->model->id;
//add route to detail view article
$this->params['breadcrumbs'][] = ['label' => \common\models\News::findOne($formModel->model->news_id)->title, 'url' => ['news/view', 'id' => $formModel->model->news_id]];
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '#'.$formModel->model->id, 'url' => ['view', 'id' => $formModel->model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'formModel' => $formModel,
    ]) ?>

</div>
