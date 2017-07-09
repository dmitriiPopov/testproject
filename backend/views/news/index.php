<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\News;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\news\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create News', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'imagefile',
            [
                'attribute' => 'category_id',
                'value' => 'category.title',
                'filter' => Html::activeDropDownList($searchModel, 'category_id',
                    ArrayHelper::map(News::find()->all(), 'category_id', 'category.title'),
                    ['prompt' => 'All']),
            ],
            [
                'attribute' => 'title',
                'value' => 'title',
                'contentOptions'=>['style'=>'white-space: normal;']
            ],
            //'description',
            [
                'attribute' => 'description',
                'value' => 'description',
                'contentOptions'=>['style'=>'white-space: normal;'],
            ],
            // 'content:ntext',
            [
                'attribute' => 'status',
                'value' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status',
                    ArrayHelper::map(News::find()->all(), 'status', 'status'),
                    ['prompt' => 'Select']),
            ],
            [
                'attribute' => 'enabled',
                'value' => function ($data) { return $data->enabled ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); },
                'filter' => Html::activeDropDownList($searchModel, 'enabled', ArrayHelper::map(News::find()->all(), 'enabled',
                    function ($data) { return $data->enabled ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); }),
                    ['prompt' => 'Select']),
            ],
            [
                'attribute' => 'display',
                'value' => function ($data) { return $data->display ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); },
                'filter' => Html::activeDropDownList($searchModel, 'display', ArrayHelper::map(News::find()->all(), 'display',
                    function ($data) { return $data->display ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); }),
                    ['prompt' => 'Select']),
            ],
            [
                'attribute' => 'created_at',
                'value' => 'created_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'language' => 'ru'
                    ]
                ])
            ],
            // 'updated_at',
            // 'public_at',
            // 'published_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('Reset', 'index', [
                    'class' => ['btn btn-reset'],
                    'style' => [
                        'border' => 'solid 1px red',
                        'padding' => '5px',
                        'color' => 'red',
                    ]
                ]),
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
