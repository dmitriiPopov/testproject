<?php

use yii\helpers\Url;

/**
 * @var $model \common\models\News
 */
?>

<!-- News block -->
<div class="list-group">
  <a href="<?= Url::toRoute(['news/view', 'id' => $model->id]); ?>" class="list-group-item">
    <h3 class="list-group-item-heading text-center"><?= $model->title; ?></h3>
    <p class="list-group-item-text text-justify"><?= $model->description; ?></p>
  </a>
</div>