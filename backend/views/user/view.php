<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Marker;

/* @var $this yii\web\View */
/* @var $model common\models\User */

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

    <?php

    //User have marker
    echo DetailView::widget([
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
                'value'     => function ($data) {
                    return $data->status === \common\models\User::STATUS_ACTIVE ? Yii::t('app', 'Active') : Yii::t('app', 'Deleted');
                },
            ],
            [
                'attribute'      => 'marker_id',
                'value'          => '',
                'contentOptions' => ['id' => 'map', 'height' => '350', 'hidden' => $model->marker_id ? false : true],
                'captionOptions' => ['hidden' => $model->marker_id ? false : true],
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'imagefile',
                'value'     => $model->getImageFileLink(),
                'format'    => ['image', ['width' => '250', 'class' => 'img-rounded']],
            ]
        ],
    ]);

    ?>

</div>

<script>

    //function for initialization
    function initMap() {

        //check model has marker
        <?php if (Marker::findOne($model->marker_id)) : ?>

            var element = document.getElementById('map');
            //map options
            var options = {
                zoom: 10,
                center: {
                    lat: <?= Marker::findOne($model->marker_id)->latitude; ?>,
                    lng: <?= Marker::findOne($model->marker_id)->longitude; ?>
                }
            };

            //create map
            var myMap = new google.maps.Map(element, options);

            //create marker
            var myMarker = new google.maps.Marker({
                position: {
                    lat: <?=
                    //TODO: пересмотри тут и везде по коду к задаче по гугл картам повторное использование Marker::findOne. Исключи его. Используй реляцию объекта класса User
                    Marker::findOne($model->marker_id)->latitude; ?>,
                    lng: <?= Marker::findOne($model->marker_id)->longitude; ?>
                },
                map: myMap
            });

        <?php endif; ?>

    }

</script>

<!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= Yii::$app->params['google_map_key']; ?>&callback=initMap">
</script>