<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\News;
use common\models\Tags;
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
        'filterModel'  => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'imagefile',
            [
                'attribute'      => 'category_id',
                'value'          => 'category.title',
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center;'],
                'filterOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'filter'         => Html::activeDropDownList($searchModel, 'category_id',
                    ArrayHelper::map(News::find()->all(), 'category_id', 'category.title'),
                    [
                        'prompt' => 'All',
                        'style'  => 'text-align: center; vertical-align: middle;',
                        'class'  => 'form-control',
                    ]),
            ],
            [
                'attribute'      => 'title',
                'value'          => 'title',
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'white-space: normal;']
            ],
            //'description',
            [
                'attribute'      => 'description',
                'value'          => 'description',
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'attribute'      => 'tag_id',
                'label'          => 'Tags',
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center;'],
                'filterOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'value'          => function($data) {
                    $tagNames = [];
                    foreach ($data->tags as $tag) {
                        $tagNames[] = ($tag->enabled ? $tag->name : $tag->name." (disabled)");
                    }
                    return implode(', ', $tagNames);
                },
            ],
            // 'content:ntext',
            [
                'attribute'      => 'status',
                'value'          => 'status',
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'filterOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'filter'         => Html::activeDropDownList($searchModel, 'status',
                    ArrayHelper::map(News::find()->all(), 'status', 'status'),
                    [
                        'prompt' => 'All',
                        'style'  => 'text-align: center; vertical-align: middle;',
                        'class'  => 'form-control',
                    ]),
            ],
            [
                'attribute'      => 'display',
                'value'          => function ($data) { return $data->display ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); },
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'filterOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'filter'         => Html::activeDropDownList($searchModel, 'display', ArrayHelper::map(News::find()->all(), 'display',
                    function ($data) { return $data->display ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); }),
                    [
                        'prompt' => 'All',
                        'style'  => 'text-align: center; vertical-align: middle; width: 70px',
                        'class'  => 'form-control',
                    ]),
            ],
            [
                'attribute'      => 'created_at',
                'value'          => 'created_at',
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'filter'         => DatePicker::widget([
                    'model'         => $searchModel,
                    'attribute'     => 'created_at',
                    'clientOptions' => [
                        'autoclose'      => true,
                        'format'         => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'language'       => 'ru'
                    ]
                ])
            ],
            // 'updated_at',
            // 'public_at',
            // 'published_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('Reset', 'index', [
                    'class' => ['btn btn-default btn-danger'],
                ]),
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
