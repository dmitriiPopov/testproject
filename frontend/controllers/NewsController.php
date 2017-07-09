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
use yii\filters\VerbFilter;

class NewsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Displays article
     * @param integer $id
     */
    public function actionView($id)
    {
        $article = News::findOne($id);

        return $this->render('view', [
            'article' => $article,
        ]);
    }

    /**
     * Displays all articles at category
     * @param integer $id
     */
    public function actionCategory($id)
    {
        $articles = News::findAtCategory($id);
        $category = Category::findOne($id);

        return $this->render('category', [
            'articles' => $articles,
            'category' => $category,
        ]);
    }


}