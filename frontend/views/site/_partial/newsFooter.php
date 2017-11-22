<?php

use yii\helpers\Url;

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
            //check tag if display
            if ($tag->display) { ?>
                <a href="" class="btn btn-success"><?= $tag->name; ?></a><?php
            }
        }
    ?>
</div>
<!--Tab with list of tags END -->