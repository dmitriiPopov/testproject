<?php

use yii\helpers\Url;

/**
 * @var $categories \common\models\Category[]
 * @var $selectedCategory \common\models\Category
 * @var $tags \common\models\Tags[]
 * @var $tagsOfNews[]
 */
?>

<!-- Tab with list of categories. Selected category must be highlighted BEGIN -->

<div class="list-group text-center col-md-3">
    <h4 class="list-group-item-heading">Categories</h4>

    <!-- Tab with name "All" category BEGIN -->
    <?php
        //check the selected Category is set
        if(isset($selectedCategory)){
            ?><a href="<?= Url::to(['site/index']); ?>" class="list-group-item">All</a><?php
        }else{
            //highlighting this tab
            ?><a href="<?= Url::to(['site/index']); ?>" class="list-group-item active">All</a><?php
        }
    ?>
    <!-- Tab with name "All" category END -->

    <!-- Tab with list of categories BEGIN -->
    <?php
        foreach ($categories as $category){
            //check the selected Category is set
            if(isset($selectedCategory)){
                //verify that the selected category matches the categories from db
                if($category->title == $selectedCategory->title){ ?>
                    <!-- highlighting the selected category -->
                    <a href="<?= Url::to(['news/category', 'id' => $category->id]); ?>" class="list-group-item active"><?= $category->title; ?></a><?php
                }else{
                    ?><a href="<?= Url::to(['news/category', 'id' => $category->id]); ?>" class="list-group-item"><?= $category->title; ?></a><?php
                }
            }else {
                ?><a href="<?= Url::to(['news/category', 'id' => $category->id]); ?>" class="list-group-item"><?= $category->title; ?></a><?php
            }
        }
    ?>
    <!-- Tab with list of categories END -->

    <!--Tab with list of tags BEGIN -->
    <h4 class="list-group-item-heading" style="margin-top: 15px;">Tags</h4>
    <?php
    foreach ($tags as $tag) {
        foreach ($tagsOfNews as $tagOfNews) {
            if ($tag->id == $tagOfNews) { ?>
                <!-- name of tag and count news with the tag -->
                <a type="button" class="btn btn-success" style="margin-bottom: 5px;"><?= $tag->name . ' '; ?><span
                        class="badge"><?= $tag->getCountNews(); ?></span></a><?php
            }else{ ?>
                <!-- name of tag and count news with the tag -->
                <a type="button" class="btn btn-primary" style="margin-bottom: 5px;"><?= $tag->name . ' '; ?><span
                        class="badge"><?= $tag->getCountNews(); ?></span></a><?php

            }
        }
    }
    //var_dump($tagsOfNews);die;
    ?>
    <!--Tab with list of tags END-->

</>
<!-- Tab with list of categories. Selected category must be highlighted END -->

