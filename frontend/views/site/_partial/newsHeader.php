<?php

use yii\helpers\Url;

/**
 * @var $categories \common\models\Category[]
 * @var $selectedCategory \common\models\Category
 * @var $tags \common\models\Tags[]
 * @var $selectedTag  \common\models\Tags
 */


$urlParameters = [];

if (!empty($selectedTag)) {
    $urlParameters['tagId'] = $selectedTag->id;
}

if (!empty($selectedCategory)) {
    $urlParameters['categoryId'] = $selectedCategory->id;
}
?>

<!-- Tab with list of categories. Selected category must be highlighted BEGIN -->

<div class="list-group text-center col-md-3">

    <h4 class="list-group-item-heading">Categories</h4>
    <!-- Tab with name "All" category BEGIN -->
    <a href="<?= Url::to(['site/index'] + ((!empty($selectedTag)) ? ['tagId' => $selectedTag->id] : [])); ?>"
       class="list-group-item <?= (!empty($selectedCategory)) ? '' : 'active';?>">All
    </a>
    <!-- Tab with name "All" category END -->

    <!-- Tab with list of categories BEGIN -->
    <?php foreach ($categories as $category) : ?>

        <a
            href="<?= Url::to(['site/index'] + array_merge($urlParameters, ['categoryId' => $category->id])); ?>"
            class="list-group-item<?= ($selectedCategory && $category->id == $selectedCategory->id)
               ? ' list-group-item-success active'
               : '';?>">
            <?= $category->title; ?>
        </a>

    <?php endforeach; ?>
    <!-- Tab with list of categories END -->

    <!--Tab with list of tags BEGIN -->
    <h4 class="list-group-item-heading" style="margin-top: 15px;">Tags</h4>

    <a href="<?= Url::to(['site/index']); ?>"
       class="btn <?= (!empty($selectedTag)) ? 'btn-primary' : 'btn-success';?>" style="margin-bottom: 5px;">All
    </a>

    <?php foreach ($tags as $tag) : ?>

        <!-- name of tag and count news with the tag -->
        <a href="<?= Url::to(['site/index'] + array_merge($urlParameters, ['tagId' => $tag->id])); ?>"
           type="button" class="btn <?= (!empty($selectedTag) && $tag->id == $selectedTag->id)
            ? 'btn-success'
            : 'btn-primary';?>" style="margin-bottom: 5px;">
            <?= $tag->name ?> <span class="badge"><?= $tag->getCountNews(); ?></span>
        </a>

    <?php endforeach; ?>
    <!--Tab with list of tags END-->

</div>
<!-- Tab with list of categories. Selected category must be highlighted END -->

