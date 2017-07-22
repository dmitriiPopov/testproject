<?php

use yii\helpers\Url;

/**
 * @var $model \common\models\News
 */
?>

<!-- News block BEGIN -->
<div class="list-group">
  <a href="<?= Url::to(['news/view', 'id' => $model->id]); ?>" class="list-group-item">
    <h3 class="list-group-item-heading text-center"><?= $model->title; ?></h3>
    <p class="list-group-item-text text-justify"><?= $model->description; ?></p>
  </a>
</div>
<!-- News block END-->