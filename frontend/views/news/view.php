<?php

/* @var $this yii\web\View */

$this->title = $article->title;
$this->params['breadcrumbs'][] = ['label' => $article->category->title, 'url' => ['news/category', 'id' => $article->category->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="main-container">
    <div class="row">
        <div class="col-md-9">
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
        </div>
    </div>
</div>
