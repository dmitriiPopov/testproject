<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Tags;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\tags\TagsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tags', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'name',
            [
                'attribute'      => 'name',
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
            ],
            //'enabled',
            //'display',
            [
                'attribute'      => 'enabled',
                'value'          => function ($data) { return $data->enabled ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); },
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'filterOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'filter'         => Html::activeDropDownList($searchModel, 'enabled',
                    ArrayHelper::map(Tags::find()->all(), 'enabled',
                    function ($data) { return $data->enabled ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); }),
                    [
                        'prompt' => 'Select',
                        'style'  => 'text-align: center; vertical-align: middle;',
                        'class'  => 'btn btn-info',
                    ]),
            ],
            [
                'attribute'      => 'display',
                'value'          => function ($data) { return $data->display ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); },
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'filterOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'filter'         => Html::activeDropDownList($searchModel, 'display',
                    ArrayHelper::map(Tags::find()->all(), 'display',
                    function ($data) { return $data->display ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); }),
                    [
                        'prompt' => 'Select',
                        'style'  => 'text-align: center; vertical-align: middle;',
                        'class'  => 'btn btn-info',
                    ]),
            ],
            //'created_at',
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
            // 'updated_at',

            [
                'class'  => 'yii\grid\ActionColumn',
                'header' => Html::a('Reset', 'index', [
                    'class' => ['btn btn-default btn-danger'],
                ]),
                'headerOptions'  => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
