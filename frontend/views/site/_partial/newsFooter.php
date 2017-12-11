<?php

/**
 * @var $tagsOfNews[]
 */

use yii\helpers\Url;

?>

<!--Tab with list of tags BEGIN -->
<div class="breadcrumb">
    <span style="font-style: italic; font-size: large;">Tags: </span>

    <?php foreach ($tagsOfNews as $tag) : ?>

        <a href="<?= Url::to(['site/index', 'tagId' => $tag->id]); ?>" class="btn btn-success"><?= $tag->name; ?></a>

    <?php endforeach; ?>

</div>
<!--Tab with list of tags END -->