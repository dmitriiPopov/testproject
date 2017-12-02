<?php

use yii\helpers\Url;

/**
 * @var $categories \common\models\Category[]
 * @var $selectedCategory \common\models\Category
 * @var $tags \common\models\Tags[]
 */
?>

<!-- Tab with list of categories. Selected category must be highlighted BEGIN -->

<div class="list-group text-center col-md-3">
    <h4 class="list-group-item-heading">Categories</h4>

    <!-- Tab with name "All" category BEGIN -->
    <?php
        //check the selected Category is set
        if (isset($selectedCategory)) : ?>

            <a href="<?= Url::to(['site/index']); ?>" class="list-group-item">All</a>

        <?php
            //highlighting this tab
            else: ?>

            <a href="<?= Url::to(['site/index']); ?>" class="list-group-item active">All</a>

    <?php endif; ?>
    <!-- Tab with name "All" category END -->

    <!-- Tab with list of categories BEGIN -->
    <?php
        foreach ($categories as $category)
        {
            //check the selected Category is set
            if(isset($selectedCategory)){
                //verify that the selected category matches the categories from db
                if($category->id == $selectedCategory->id){ ?>
                    <!-- highlighting the selected category -->
                    <a href="<?= Url::to(['site/index', 'categoryId' => $category->id]); ?>" class="list-group-item active"><?= $category->title; ?></a><?php
                }else{
                    ?><a href="<?= Url::to(['site/index', 'categoryId' => $category->id]); ?>" class="list-group-item"><?= $category->title; ?></a><?php
                }
            }else {
                ?><a href="<?= Url::to(['site/index', 'categoryId' => $category->id]); ?>" class="list-group-item"><?= $category->title; ?></a><?php
            }
        }
    ?>
    <!-- Tab with list of categories END -->

    <!--Tab with list of tags BEGIN -->
    <h4 class="list-group-item-heading" style="margin-top: 15px;">Tags</h4>
    <?php
        foreach ($tags as $tag)
        { ?>
            <!-- name of tag and count news with the tag -->
            <a href="" type="button" class="btn btn-primary" style="margin-bottom: 5px;"><?= $tag->name . ' '; ?>
            <span class="badge"><?= $tag->getCountNews(); ?></span></a><?php
        }
    ?>
    <!--Tab with list of tags END-->

</>
<!-- Tab with list of categories. Selected category must be highlighted END -->

