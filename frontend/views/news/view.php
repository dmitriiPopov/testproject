<?php

/**
 * @var $this yii\web\View
 * @var $article
 * @var $categories
 * @var $selectedCategory
 * @var $tags
 * @var $tagsOfNews[]
 */

$this->title = $article->title;
//check is set selected category DISPLAY ON
if (isset($selectedCategory)) {
    $this->params['breadcrumbs'][] = ['label' => $selectedCategory->title, 'url' => ['site/index', 'categoryId' => $selectedCategory->id]];
}
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="main-container">
    <div class="row">
        <div class="col-md-9">

            <!-- Article -->
            <article class="post">
                <div class="post-thumb"></div>
                <div class="post-content">
                    <header class="text-center text-uppercase">
                        <h1 class="nv-title"><?= $article->title; ?></h1>
                    </header>
                    <h4 class="nv-subtitle text-center">
                        <?= $article->description; ?>
                    </h4>
                    <div class="content text-justify">
                        <p><?= $article->content; ?></p>
                    </div>
                </div>
            </article>
            <!-- End article -->

            <!-- List of tags of the news -->
            <?php
                //check is set tagsOfNews
                if ( ! empty($tagsOfNews)) {
                    echo $this->render('../site/_partial/newsFooter', [
                        'tagsOfNews' => $tagsOfNews,
                    ]);
                }
            ?>
            <!-- End list of tags of the news -->

        </div>

        <!-- List of categories -->
        <?= $this->render('../site/_partial/newsHeader', [
            'categories'       => $categories,
            'selectedCategory' => $selectedCategory,
            'tags'             => $tags,
        ]); ?>
        <!-- End list of categories -->

    </div>
</div>
