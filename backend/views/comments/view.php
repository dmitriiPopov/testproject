<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = $model->id;
//add route to detail view article
$this->params['breadcrumbs'][] = ['label' => \common\models\News::findOne($model->news_id)->title, 'url' => ['news/view', 'id' => $model->news_id]];
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = '#'.$this->title;

?>
<div class="comment-view">

    <h1><?= Html::encode('Comment #'.$this->title.' on the article "'.\common\models\News::findOne($model->news_id)->title.'"') ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'user.username',
            'news.title',
            'content:ntext',
            [
                'attribute' => 'enabled',
                'value'     => function ($data) { return $data->enabled ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); },
            ],
            'created_at',
            [
                'attribute' => 'updated_at',
                'value'     => function ($data) { return $data->updated_at ? $data->updated_at : 'Not updated'; },
            ],
        ],
    ]) ?>

</div>
