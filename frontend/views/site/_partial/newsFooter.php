<?php

/**
 * @var $tagsOfNews[]
 */

?>

<!--Tab with list of tags BEGIN -->
<div class="breadcrumb">
    <span style="font-style: italic; font-size: large;">Tags: </span>
    <?php
        foreach ($tagsOfNews as $tag)
        {
            ?><a href="" class="btn btn-success"><?= $tag->name; ?></a> <?php
        }
    ?>
</div>
<!--Tab with list of tags END -->