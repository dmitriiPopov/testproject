<?php

use yii\widgets\LinkPager;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

?>
<div class="site-index">

    <div class="row">
        <div class="col-md-9">

            <?php foreach ($articles as $article): ?>
                <article class="post">
                    <div class="post-thumb"></div>
                    <div class="post-content">
                        <header class="text-center text-uppercase">

                            <h6><a href="<?= Url::toRoute(['news/category', 'id' => $article->category->id]); ?>"><?= $article->category->title; ?></a></h6>
                            <h1 class="nv-title"><a href="<?= Url::toRoute(['news/view', 'id' => $article->id]); ?>"><?= $article->title; ?></a></h1>

                        </header>
                        <div class="popover-content">
                            <p><?= $article->description; ?></p>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>

            <div style="text-align: center">
                <?= LinkPager::widget([
                    'pagination' => $pagination,
                ]); ?>
            </div>

        </div>
        <div class="col-md-3">
            <aside class="border pos-padding">
                <h3 class="text-uppercase text-center">Categories</h3>
                <ul>
                    <?php foreach ($categories as $category): ?>
                        <li>
                            <a href="<?= Url::toRoute(['news/category', 'id' => $category->id]); ?>"><?= $category->title; ?></a>
                            <span class="post-count pull-right">(<?= $category->getArticlesCount(); ?>)</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>
        </div>
    </div>

</div>
