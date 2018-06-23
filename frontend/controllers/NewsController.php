<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 05.07.17
 * Time: 0:21
 */

namespace frontend\controllers;

use common\models\Category;
use common\models\Comment;
use common\models\News;
use common\models\Tags;
use frontend\components\forms\CommentForm;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

/**
 * Class NewsController
 * @package frontend\controllers
 *
 * Show news with categories
 */
class NewsController extends Controller
{
    /**
     * Displays article
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        //get data for selected article (by `id`)
        /**@var $article News*/
        $article = News::find()->andWhere(['id' => $id, 'display' => News::DISPLAY_ON])->one();

        //if it isn't found
        if (!$article) {
            throw new NotFoundHttpException();
        }

        //array of categories
        $categories = Category::find()->andWhere(['display' => Category::DISPLAY_ON])->all();
        //array of tags
        $tags       = Tags::find()->andWhere(['display' => Tags::DISPLAY_ON])->all();
        //Data Provider of comments for ListView
        $comments   = new ActiveDataProvider([
            'query'      => Comment::find()->andWhere(['news_id' => $id, 'enabled' => Comment::ENABLED_ON])->orderBy('id DESC'),
//            'pagination' => [
//                'pageSize' => 3,
//            ],
        ]);
        //create comment form with scenario Create
        $commentForm = new CommentForm(['scenario' => CommentForm::SCENARIO_CREATE]);

        return $this->render('view', [
            'article'          => $article,
            'categories'       => $categories,
            'selectedCategory' => $article->getCategory()->andWhere(['display' => Category::DISPLAY_ON])->one(),
            'tags'             => $tags,
            'tagsOfNews'       => ArrayHelper::map($article->getTags()->andWhere(['display' => Tags::DISPLAY_ON])->all(), 'id', 'id'),
            'comments'         => $comments,
            'commentForm'      => $commentForm,
        ]);
    }
}