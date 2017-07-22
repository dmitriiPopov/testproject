<?php

use yii\helpers\Url;

/**
 * @var $categories \common\models\Category[]
 * @var $selectedCategory \common\models\Category
 */
?>

<!-- Tab with list of categories. Selected category must be highlighted -->

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

</div>