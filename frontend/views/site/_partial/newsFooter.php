<?php

/**
 * @var $tagsOfNews[]
 */

?>

<!--Tab with list of tags BEGIN -->
<div class="breadcrumb">
    <span style="font-style: italic; font-size: large;">Tags: </span>

    <?php //TODO: используй ТОЛЬЕО такую форму пхп операций (if, for, while, foreach) во вьюхах, если внутри этих операций html/js . Это очень удобно и очень хороший тон. ?>
    <?php foreach ($tagsOfNews as $tag) : ?>

        <a href="" class="btn btn-success"><?= $tag->name; ?></a>

    <?php endforeach; ?>

</div>
<!--Tab with list of tags END -->