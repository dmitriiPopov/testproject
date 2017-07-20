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
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

class NewsController extends Controller
{
    /**
     * Displays article
     * @param integer $id
     */
    public function actionView($id)
    {
        $article = News::find()->andWhere(['id' => $id, 'display' => News::DISPLAY_ON])->one();
        //if it isn't found
        if (!$article) {
            throw new NotFoundHttpException();
        }

        //array of categories
        $categories = Category::find()->andWhere(['display' => Category::DISPLAY_ON])->all();

        //selected category
        $selectedCategory = $article->category;

        return $this->render('view', [
            'article'          => $article,
            'categories'       => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    /**
     * Displays all articles at some category
     * @param integer $id
     */
    public function actionCategory($id)
    {
        //selected category
        $category = Category::find()
            ->with('publishedNews')
            ->andWhere(['category.id' => $id, 'category.display' => Category::DISPLAY_ON])
            ->one();

        //if category not found
        if(!$category) {
            throw new NotFoundHttpException();
        }

        //array of categories
        $categories = Category::find()
            ->andWhere(['display' => Category::DISPLAY_ON])
            ->all();

        //List of news
        $dataProvider = new ActiveDataProvider([
            'query'      => News::find()
                ->andWhere(['category_id' => $id,'display' => News::DISPLAY_ON])
                ->orderBy('published_at DESC'),
            'pagination' => [
                'pageSize' => 4,
            ],
        ]);

        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'category'     => $category,
            'categories'   => $categories,
        ]);
    }


}