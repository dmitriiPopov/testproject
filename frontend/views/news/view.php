<?php

/**
 * @var $this yii\web\View
 * @var $article
 * @var $categories
 * @var $selectedCategory
 * @var $tags
 * @var $tagsOfNews[]
 * @var $comments yii\data\ActiveDataProvider
 * @var $commentForm
 * @var $commentScenario
 * @var $commentId
 */

use yii\helpers\Html;
use frontend\components\forms\CommentForm;

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
            <hr>
            <!-- End article -->

    <!-- Comments -->

            <h3>Комментарии</h3>
            <hr style="border: none; color: grey; background-color: grey; height: 3px;">

            <!-- BEGIN comment's form -->
            <?php if(Yii::$app->user->isGuest): ?>
                <div style="font-style: italic; font-size: large; text-align: center;">Чтобы иметь возможность оставлять комментарий, нужно авторизоваться!</div>
            <?php else: ?>
                <div class="row">
                    <div class="comment-form col-lg-12">
                        <!-- BEGIN form widget -->
                        <?= $this->render('_partial/commentForm', [
                            'article'         => $article,
                            'commentForm'     => $commentForm,
                            'commentScenario' => $commentScenario,
                            'commentId'       => $commentId,
                        ]); ?>
                        <!-- END form widget -->
                    </div>
                </div>

            <?php endif; ?>

            <!-- END comment's form -->

            <!-- List of comments BEGIN -->
            <div id="comments" class="col-lg-12">
                <?= $this->render('_partial/commentsList', [
                    'comments' => $comments,

                ]); ?>
            </div>
            <!-- List of comments END -->

        <!-- End comments -->
        </div>

        <!-- List of categories -->
        <?= $this->render('../site/_partial/newsHeader', [
            'categories'       => $categories,
            'selectedCategory' => $selectedCategory,
            'tags'             => $tags,
            'tagsOfNews'       => $tagsOfNews,
        ]); ?>
        <!-- End list of categories -->

    </div>
</div>

<?php $this->registerJs("
    $(document).on('submit', '#commentForm', function(e) {

         e.preventDefault();

         var data = $(this).serialize();
         console.log(data);

         $.ajax({
              url: '/comments/create?articleId=".$article->id."',
              type: 'POST',
              data: data,
              success: function(responseHtml) {
        	      $('#comments').prepend(responseHtml);  
        	      $('#commentForm').trigger('reset');
        	      $('.empty').hide();
              },
              error: function() {
                  console.log('Error!');
              }
          });
    });
    
    $(document).on('click', 'button.glyphicon-pencil', function(e) {
    
        e.preventDefault();
        
        //надо ли эти данные?
        var data = {
            articleId: $article->id,
            id: $(this).attr('alt') 
        }
        //урл задал как строку, в конце вставляю id комментария спомощью атрибута alt
        var url = '/comments/updating?articleId=".$article->id."&id=' +$(this).attr('alt');        
        
        if (confirm('Are you sure you want to update this item?')) {

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) { 
                   //принимаю json и необходимые данные вставляю в форму
                },
                error: function() {
                    console.log('Error!');
                }
          });
        }
        
        
    });
", \yii\web\View::POS_END);
?>
