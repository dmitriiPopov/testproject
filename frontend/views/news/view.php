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
 * @var string $userName
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
                        <?= $this->render('_partial/commentFormItem', [
                            'commentForm' => $commentForm,
                        ]); ?>
                        <!-- END form widget -->
                    </div>
                </div>

            <?php endif; ?>

            <!-- END comment's form -->

            <!-- List of comments BEGIN -->
            <div id="comments" class="col-lg-12">
                <?= $this->render('_partial/commentsListItem', [
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

    /* CREATE OR UPDATE COMMENT */
    $(document).on('submit', '#commentForm', function(e) {

         e.preventDefault();

         // if form fields are NOT filled and valid
         if (!commentFormJsValidate())
         {
            // interrupt submitting form
            return false;
         }

         var data = $(this).serializeArray();
             
         /* Create */
         if ($('#commentForm').attr('action') == '/comments/create?articleId=".$article->id."') {
         
                $.ajax({
                      url: '/comments/create?articleId=".$article->id."',
                      type: 'POST',
                      data: data,
                      success: function(responseHtml) {
                      
                          if (responseHtml != '') {
                             
                              // if form has been returned
                              if ($(responseHtml).attr('id') == 'commentForm')
                              {
                                  // it means that form contents errors
                                  $(document).find('#commentForm').html(responseHtml);
                              }
                              // if comment has been returned
                              else {
                                  // put created comment to comments list
                                  $('#comments').prepend(responseHtml);  
                                  $('#commentform-content').val('');
                                  $('.empty').hide();
                                  
                                  //TODO: Удалить валидационные ошибки из формы
                              } 
                          }
                      },
                      error: function() {
                          console.log('Error!');
                      }
                });
         };
             
         /* Update */
         if (
            $('#commentForm').attr('action') 
            == 
            '/comments/update?id='+$('#commentform-id').val()
        ) {
         
                var commentId = $('#commentform-id').val();

                $.ajax({
                      url: '/comments/update?id='+commentId,
                      type: 'POST',
                      data: data,
                      success: function(responseHtml) {
                      
                          if (responseHtml != '') {
                              $('div.list-group > div#comment-'+commentId).replaceWith(responseHtml);  
                              $('#commentform-content').val('');
                              $('#buttonForm').attr('class', 'btn btn-success');
                              $('#buttonForm').text('Оставить комментарий');

                              $('#commentForm').attr('action', '/comments/create?articleId=".$article->id."');
                          }
                      
                      },
                      error: function() {
                          console.log('Error!');
                      }
                });
         };
    });

    /* GET COMMENT DATA AND PUT IN FORM */
    $(document).on('click', '.updateComment', function(e) {
    
        e.preventDefault();

        var commentId = $(this).attr('data-id');        

        $.ajax({
            url: '/comments/one?id='+commentId,
            type: 'POST',
            data: {},
            dataType: 'json',
            success: function(jsonResponse) {  
              
                if (jsonResponse.length != 0) {
                
                    var commentId = jsonResponse['id'];
                
                    $('#commentform-id').val(jsonResponse['id']);
                    $('#commentform-name').val(jsonResponse['name']);
                    $('#commentform-content').val(jsonResponse['content']);
                    
                    $('#commentForm').attr('action', '/comments/update?id='+commentId);
                    
                    
                    $('#buttonForm').attr('class', 'btn btn-primary');
                    $('#buttonForm').text('Изменить комментарий');
                    
                }
                
            },
            error: function() {
                console.log('Error!');
            }
        });      
    });
    
    /* DELETE COMMENT */
    $(document).on('click', '.deleteComment', function(e) {
    
        e.preventDefault();

        var commentId = $(this).attr('data-id');        
        
        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: '/comments/delete?id='+commentId,
                type: 'POST',
                data: {},
                dataType: 'json',
                success: function(jsonResponse) {
                    if (jsonResponse['status'] && jsonResponse['deleted']) {
                        $('div.list-group > div#comment-'+commentId).hide();
                    }
                },
                error: function() {
                    console.log('Error!');
                }
            });      
        }
    });

    
    function commentFormJsValidate()
    {
        var nameValue    = $('#commentform-name').val();
        var contentValue = $('#commentform-content').val();

        if (nameValue === '' || contentValue === '')
        {
            if (nameValue === '') {
                $('div.field-commentform-name > div.help-block').text('Name cannot be blank.');
                $('div.field-commentform-name').attr('class', 'form-group field-commentform-name required has-error');
            } else {
                $('div.field-commentform-content > div.help-block').text('Content cannot be blank.');
                $('div.field-commentform-content').attr('class', 'form-group field-commentform-content required has-error');
            }

            return false;
        }

        return true;
    }

", \yii\web\View::POS_END);
?>
