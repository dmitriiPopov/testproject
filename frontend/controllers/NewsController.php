<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 05.07.17
 * Time: 0:21
 */

namespace frontend\controllers;

use common\models\Category;
use common\models\News;
use common\models\Tags;
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
     */
    public function actionView($id)
    {
        //get data for selected article (by `id`)
        $article = News::find()->andWhere(['id' => $id, 'display' => News::DISPLAY_ON])->one();

        //if it isn't found
        if ( ! $article) {
            throw new NotFoundHttpException();
        }

        //check if category of article is DISPLAY_ON
        if ($article->category->display) {
            $selectedCategory = $article->category;
        } else {
            $selectedCategory = null;
        }

        //check if tags of article is DISPLAY_ON
        if ( ! empty($tagsOfNews = $article->tags)) {
            foreach ($tagsOfNews as $key => $tag) {
                if ( ! $tag->display) {
                    unset($tagsOfNews[$key]);
                }
            }
        }

        //array of categories
        $categories = Category::find()->andWhere(['display' => Category::DISPLAY_ON])->all();
        //array of tags
        $tags       = Tags::find()->andWhere(['display' => Tags::DISPLAY_ON])->all();

        return $this->render('view', [
            'article'          => $article,
            'categories'       => $categories,
            'selectedCategory' => $selectedCategory,
            'tags'             => $tags,
            'tagsOfNews'       => $tagsOfNews,
        ]);
    }
}