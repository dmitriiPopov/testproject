<?php

use yii\helpers\Url;

/**
 * @var $categories       \common\models\Category[]
 * @var $selectedCategory \common\models\Category
 * @var $tags             \common\models\Tags[]
 * @var $selectedTags     \common\models\Tags []
 * @var $tagsOfNews       \common\models\Tags []
 */

//var_dump(Yii::$app->request->queryParams['tagId']);die;
$selectedTagsIdArray = [];
$urlParameters = [];

if (!empty($selectedTags)) {

        foreach ($selectedTags as $tag) {

            array_push($selectedTagsIdArray, $tag->id);
        }

        $urlParameters['selectedTags'] = implode('+', $selectedTagsIdArray);
}

if (!empty($selectedCategory)) {
    $urlParameters['categoryId'] = $selectedCategory->id;
}

?>

<!-- Tab with list of categories. Selected category must be highlighted BEGIN -->

<div class="list-group text-center col-md-3">

    <h4 class="list-group-item-heading">Categories</h4>
    <!-- Tab with name "All" category BEGIN -->
    <a href="<?= Url::to(['site/index'] + ((!empty($selectedTags)) ? ['selectedTags' => $urlParameters['selectedTags']] : [])); ?>"
       class="list-group-item <?= (!empty($selectedCategory)) ? '' : 'list-group-item-success active';?>">All
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
       class="btn <?= (!empty($selectedTags) || !empty($tagsOfNews)) ? 'btn-primary' : 'btn-success';?>" style="margin-bottom: 5px; padding: 2px 15px; border-radius: 15px;">All
    </a>

    <?php foreach ($tags as $tag) : ?>

        <!-- name of tag and count news with the tag -->
        <a href="<?= Url::to(['site/index', 'selectedTags' => (!empty($urlParameters['selectedTags']) ? $urlParameters['selectedTags'].'+'.$tag->id :  $tag->id )]); ?>"
           class="btn <?= ((!empty($selectedTags) && in_array($tag->id, $selectedTagsIdArray)) || (!empty($tagsOfNews) && array_key_exists($tag->id, $tagsOfNews)))
            ? 'btn-success'
            : 'btn-primary'; ?>" style="margin-bottom: 5px; padding: 2px 5px; border-radius: 15px;">
            <?= $tag->name ?>
        </a>

    <?php endforeach; ?>
    <!--Tab with list of tags END-->
</div>
<!-- Tab with list of categories. Selected category must be highlighted END -->

