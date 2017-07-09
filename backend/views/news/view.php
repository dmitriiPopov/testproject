<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'imagefile',
            'category.title',
            'title',
            'description',
            //'content:ntext',
            'status',
            [
                'attribute' => 'enabled',
                'value' => function ($data) { return $data->enabled ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); },
            ],
            [
                'attribute' => 'display',
                'value' => function ($data) { return $data->display ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); },
            ],
            'created_at',
            [
                'attribute' => 'updated_at',
                'value' => function ($data) { return $data->updated_at ? $data->updated_at : Yii::t('app','Not updated'); },
            ],
            [
                'attribute' => 'public_at',
                'value' => function ($data) { return $data->public_at ? $data->public_at : Yii::t('app','Not public'); },
            ],
            [
                'attribute' => 'published_at',
                'value' => function ($data) { return $data->published_at ? $data->published_at : Yii::t('app','Not published'); },
            ],
        ],
    ]) ?>

</div>
