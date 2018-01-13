<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\user\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
            ],
            //'username',
            [
                'attribute' => 'username',
                'headerOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
            ],
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            //'email:email',
            [
                'attribute' => 'email',
                'format' => 'email',
                'headerOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
            ],
            [
                'attribute' => 'status',
                'headerOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'filterOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'value' => function ($data) { return $data->status === User::STATUS_ACTIVE ? Yii::t('app', 'Active') : Yii::t('app', 'Deleted'); },
                'filter' => Html::activeDropDownList($searchModel, 'status', ArrayHelper::map(User::find()->all(), 'status',
                    function ($data) { return $data->status === User::STATUS_ACTIVE ? Yii::t('app', 'Active') : Yii::t('app', 'Deleted'); }),
                    [
                        'prompt' => 'All',
                        'style'  => 'text-align: center; vertical-align: middle;',
                        'class'  => 'form-control',
                    ]),
            ],
            [
                'attribute' => 'created_at',
                'value' => 'created_at',
                'headerOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'format' => 'datetime',
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
            [
                'attribute' => 'updated_at',
                'value' => 'updated_at',
                'headerOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'language' => 'ru'
                    ]
                ])
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('Reset', 'index', [
                    'class' => ['btn btn-default'],
                    'style' => [
                        'border' => 'solid 1px #ddd',
                        'padding' => '5px',
                        'color' => '#337ab7',
                    ]
                ]),
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
