<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
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
            [
                'attribute' => 'tagsArray',
                'value'     => function ($model) {
                    // TODO: неправильно логически. Дважды выполняется тяжелая операция  ArrayHelper::map($model->tags, 'name', 'name'), при том что нам нужно проверить только наличие тегов
                    //return ArrayHelper::map($model->tags, 'name', 'name') ?
                        //implode(', ', ArrayHelper::map($model->tags, 'name', 'name')) :
                        //Yii::t('app', 'Tags not found');

                    // проверяем наличие данных в реляции. А потом уже форматируем.
                    return !empty($model->tags) ? implode(', ', ArrayHelper::map($model->tags, 'name', 'name')) : Yii::t('app', 'Tags not found');
                },
            ],
            'status',
            [
                'attribute' => 'enabled',
                'value'     => function ($data) {
                    return $data->enabled ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
                },
            ],
            [
                'attribute' => 'display',
                'value'     => function ($data) {
                    return $data->display ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
                },
            ],

            'content:raw',

            'created_at',
            'updated_at',
            'public_at',
            'published_at',
        ],
    ]) ?>

</div>
