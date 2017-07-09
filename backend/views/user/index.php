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

            'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function ($data) { return $data->status === User::STATUS_ACTIVE ? Yii::t('app', 'Active') : Yii::t('app', 'Deleted'); },
                'filter' => Html::activeDropDownList($searchModel, 'status', ArrayHelper::map(User::find()->all(), 'status',
                    function ($data) { return $data->status === User::STATUS_ACTIVE ? Yii::t('app', 'Active') : Yii::t('app', 'Deleted'); }),
                    ['prompt' => 'Select']),
            ],
            [
                'attribute' => 'created_at',
                'value' => 'created_at',
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
<?php Pjax::end(); ?></div>