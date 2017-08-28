<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\user\UserForm */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'username',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            'email:email',
            [
                'attribute' => 'status',
                'value'     => function ($data) { return $data->status === \common\models\User::STATUS_ACTIVE ? Yii::t('app', 'Active') : Yii::t('app', 'Deleted'); },
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'imagefile',
                'value'     => sprintf('%s/%s/%s',
                    \Yii::$app->params['staticBaseUrl'],
                    \Yii::$app->params['staticPathUserAvatar'],
                    $model->imagefile
                ),
                'format'    => ['image', ['width'=>'250', 'class'=>'img-rounded']],
            ]
        ],
    ]) ?>

</div>
