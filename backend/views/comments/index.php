<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Comment;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\comments\CommentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1 style="padding-bottom: 45px;"><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns' => [
            [
                'class'          => 'yii\grid\SerialColumn',
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
            ],
            [
                'attribute' => 'id',
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
            ],
            [
                'attribute'      => 'user_id',
                'value'          => 'user.username',
                'contentOptions' => ['style' => 'text-align: center;'],
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'filter'         => Html::activeDropDownList($searchModel, 'user_id',
                    ArrayHelper::map(Comment::find()->all(), 'user_id', 'user.username'),
                    [
                        'prompt' => 'All',
                        'style'  => 'text-align: center; vertical-align: middle;',
                        'class'  => 'form-control',
                    ]),
                'filterOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
            ],
            [
                'attribute'      => 'news_id',
                'value'          => 'news.title',
                'contentOptions' => ['style' => 'text-align: center;'],
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'filter'         => Html::activeDropDownList($searchModel, 'news_id',
                    ArrayHelper::map(Comment::find()->all(), 'news_id', 'news.title'),
                    [
                        'prompt' => 'All',
                        'style'  => 'text-align: center; vertical-align: middle;',
                        'class'  => 'form-control',
                    ]),
                'filterOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
            ],
            'content:ntext',
            [
                'attribute'      => 'enabled',
                'value'          => function ($data) { return $data->enabled ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); },
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'filterOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'filter'         => Html::activeDropDownList($searchModel, 'enabled', ArrayHelper::map(Comment::find()->all(), 'enabled',
                    function ($data) { return $data->enabled ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); }),
                    [
                        'prompt' => 'All',
                        'style'  => 'text-align: center; vertical-align: middle;',
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
                    ]
                ])
            ],
            //'updated_at',

            [
                'class'          => 'yii\grid\ActionColumn',
                'header'         => Html::a('Reset', 'index', [
                    'class' => ['btn btn-default btn-danger'],
                ]),
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
