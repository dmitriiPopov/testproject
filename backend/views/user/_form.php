<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\models\User;
use \common\models\Marker;

/* @var $this yii\web\View */
/* @var $formModel backend\models\user\UserForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($formModel, 'username')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'password')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'email')->textInput(['maxlength' => true]) ?>

    <?php
        if(in_array($formModel->scenario, [$formModel::SCENARIO_UPDATE])){
           echo Html::img($formModel->model->getImageFileLink(), ['width'=>'120', 'height'=>'120', 'class'=>'img-circle']);
           //add button 'delete' if avatar aren't default
           if($formModel->model->imagefile && file_exists($formModel->model->getImageFileAbsolutePath())){
               echo ' '.Html::a(Yii::t('app', 'Delete'), ['avatardelete', 'id' => $formModel->model->id], [
                   'class' => 'btn btn-danger',
                   'data'  => [
                       'confirm' => 'Are you sure you want to remove this avatar?',
                       'method'  => 'post',
                   ],
                   'style' => [
                       //'vertical-align' => 'top',
                   ],
               ]);
           }
        }

    ?>

    <?= $form->field($formModel, 'avatar')->fileInput() ?>

    <?php

        if (in_array($formModel->scenario, [$formModel::SCENARIO_UPDATE])){

            $userStatus   = $formModel->status;
            $itemsActive  = array(User::STATUS_ACTIVE  => Yii::t('app', 'Active'),  User::STATUS_DELETED => Yii::t('app', 'Deleted'));
            $itemsDeleted = array(User::STATUS_DELETED => Yii::t('app', 'Deleted'), User::STATUS_ACTIVE  => Yii::t('app', 'Active'));

            if($userStatus === User::STATUS_ACTIVE){
                echo $form->field($formModel, 'status')->dropDownList($itemsActive);
            }else{
                echo $form->field($formModel, 'status')->dropDownList($itemsDeleted);
            }
        }

     ?>

    <?php //= $form->field($model, 'created_at')->textInput() ?>

    <?php //= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($formModel, 'latitude')->label(false)->hiddenInput(['id' => 'latitude']) ?>

    <?= $form->field($formModel, 'longitude')->label(false)->hiddenInput(['id' => 'longitude']) ?>

    <div id="map" class="form-group" style="width: 50%; height: 400px;"></div>

    <div class="form-group">
        <?= Html::submitButton($formModel->model->isNewRecord ? 'Create' : 'Update', ['class' => $formModel->model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    //array for markers
    var markersArray = [];

    //function for initialization
    function initMap() {

        var element = document.getElementById('map');
        //map options
        var options = {
            zoom: 10,
            center: {lat: 50.45466, lng: 30.5238}
        };

        //create map
        var myMap = new google.maps.Map(element, options);

        //check scenario UPDATE && model has marker
        <?php if (in_array($formModel->scenario, [$formModel::SCENARIO_UPDATE]) &&
                Marker::findOne($formModel->model->marker_id)) : ?>
            //create marker
            placeMarker(
                {
                    lat: <?= Marker::findOne($formModel->model->marker_id)->latitude; ?>,
                    lng: <?= Marker::findOne($formModel->model->marker_id)->longitude; ?>
                },
                myMap
            );

        <?php endif; ?>

        //create listener for map
        myMap.addListener('click', function(e) {
            //remove markers
            removeMarkers();
            //place marker
            placeMarker(e.latLng, myMap);
        });
    }

    //function for place marker
    function placeMarker (latLng, myMap) {
        //create marker
        var myMarker = new google.maps.Marker({
            position: latLng,
            map:      myMap,
        });
        //add new marker to array
        markersArray.push(myMarker);
        myMap.panTo(latLng);
        //set values in hidden inputs user's form
        $('#latitude').val(myMarker.getPosition().lat());
        $('#longitude').val(myMarker.getPosition().lng());
    }

    //function for remove markers
    function removeMarkers () {

        for (var i = 0; i < markersArray.length; i++){
            //delete marker from map
            markersArray[i].setMap(null);
        }
        //update array
        markersArray = [];
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