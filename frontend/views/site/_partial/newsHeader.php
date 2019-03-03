<?php

use yii\helpers\Url;

/**
 * @var $categories           \common\models\Category[]
 * @var $selectedCategory     \common\models\Category
 * @var $tags                 \common\models\Tags[]
 * @var $selectedTagsArray    \common\models\Tags []
 * @var $selectedTagsIdArray  integer []
 * @var $tagsOfNews           \common\models\Tags []
 */


$urlParameters = [];

if (!empty($selectedTagsIdArray)) {
    $urlParameters['selectedTags'] = implode('+', $selectedTagsIdArray);
}

if (!empty($selectedCategory)) {
    $urlParameters['categoryId']   = $selectedCategory->id;
}

?>

<!-- Tab with list of categories. Selected category must be highlighted BEGIN -->

<div class="list-group text-center col-md-3">

    <h4 class="list-group-item-heading">Categories</h4>

    <!-- Tab with name "All" category BEGIN -->
    <a href="<?= Url::to(
                ['site/index']
                + ((!empty($selectedTagsIdArray)) ? ['selectedTags' => $urlParameters['selectedTags']] : []));
            ?>"
       class="list-group-item <?= (!empty($selectedCategory)) ? '' : 'list-group-item-success active';?>">All
    </a>
    <!-- Tab with name "All" category END -->

    <!-- Tab with list of categories BEGIN -->
    <?php foreach ($categories as $category) : ?>

        <a
            href="<?= Url::to(
                    ['site/index']
                    + array_merge(
                            $urlParameters, ['categoryId' => $category->id]
                    )
            ); ?>"
            class="list-group-item<?= ($selectedCategory && $category->id == $selectedCategory->id)
               ? ' list-group-item-success active'
               : '';?>">
            <?= $category->title; ?>
        </a>

    <?php endforeach; ?>
    <!-- Tab with list of categories END -->

    <!--Tab with list of tags BEGIN -->
    <h4 class="list-group-item-heading" style="margin-top: 15px;">Tags</h4>

    <a href="<?= Url::to(['site/index',
        'categoryId'   => isset($urlParameters['categoryId']) ? $urlParameters['categoryId'] : [] ]); ?>"

       class="btn <?= (!empty($selectedTagsIdArray) || !empty($tagsOfNews))
           ? 'btn-primary'
           : 'btn-success'
       ;?>" style="margin-bottom: 5px; padding: 2px 15px; border-radius: 15px;">All
    </a>

    <?php foreach ($tags as $tag) : ?>

        <!-- add tag's id to array of tag's id -->
        <?php
            //check array with selected tag's id
            if (!empty($selectedTagsIdArray)) {
                //check tag's id in array
                if (in_array($tag->id, $selectedTagsIdArray)) {
                    //remove from array tag's id
                    $tagsIds = $selectedTagsIdArray;
                    unset($tagsIds[array_search($tag->id, $tagsIds)]);

                }else{
                    //adding tag's id to array
                    $tagsIds = array_merge($selectedTagsIdArray, [$tag->id]);
                }

            } else {

                $tagsIds = [$tag->id];
            }
        ?>

        <!-- name of tag and count news with the tag -->
        <a href="<?= Url::to(['site/index',
                'categoryId'   => isset($urlParameters['categoryId']) ? $urlParameters['categoryId'] : [] ]
            +  ((!empty($tagsIds)) ? ['selectedTags' => (implode('+', $tagsIds))] : [])
        ) ?>"

           class="btn <?= (isset($selectedTagsIdArray) ? in_array($tag->id, $selectedTagsIdArray) : [] ) || (!empty($tagsOfNews) && array_key_exists($tag->id, $tagsOfNews))
            ? 'btn-success'
            : 'btn-primary'; ?>" style="margin-bottom: 5px; padding: 2px 5px; border-radius: 15px;">
            <?= $tag->name ?>
        </a>

    <?php endforeach; ?>
    <!--Tab with list of tags END-->
</div>
<!-- Tab with list of categories. Selected category must be highlighted END -->

