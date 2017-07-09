<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = $category->title;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="main-container">
    <div class="row">
        <div class="col-md-9">
            <?php foreach ($articles as $article): ?>
                <article class="post">
                    <div class="post-thumb"></div>
                    <div class="post-content">
                        <header class="text-center text-uppercase">
                            <h1 class="nv-title"><a href="<?= Url::toRoute(['news/view', 'id' => $article->id]); ?>"><?= $article->title; ?></a></h1>
                        </header>
                        <div class="popover-content">
                            <p><?= $article->description; ?></p>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</div>
