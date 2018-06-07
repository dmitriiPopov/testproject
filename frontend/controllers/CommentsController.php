<?php

namespace frontend\controllers;

use Yii;
use common\models\Comment;
use frontend\components\forms\CommentForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentsController implements the CRUD actions for Comment model.
 */
class CommentsController extends Controller
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
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $articleId
     *
     * @return string HTML-string
     */
    public function actionCreate($articleId)
    {

        //TODO: 1) избегай глубокой вложености условий - if внутри if внутри if и так далее. Так нельзя.
        //TODO: 2) сразу отсекай невалидные варианты и объединяй их в одно условие, если один и тот же результат после условия (как я это сделал ниже)
        //TODO: 3) пиши информативные комментарии (больше для себя, если это необходимо).

        // if request isn't AJAX or user isn't authorized
        if(!Yii::$app->request->isAjax || Yii::$app->user->isGuest) {
            // return empty string to ajax-callback function
            return '';
        }

        //init form model instance
        $formModel = new CommentForm(['scenario' => CommentForm::SCENARIO_CREATE]);

        // create new instance of Comment model for saving below
        $formModel->setModel(new Comment());

        // save comment with data from request
        if ($formModel->load(Yii::$app->request->post()) && $formModel->save($articleId)) {
            // return html-code of one comment to ajax-callback
            return $this->renderPartial(
                '/news/_partial/commentItem',
                [
                    // set new comment ot view template
                    //TODO: тут незачем заново отправлять запрос в Бвзу Данных так, как у тебя же уже проинициализирована и сохранена нужная модель внутри CommentForm
                    'model' => $formModel->getModel(),
                ]
            );
        }

        // return empty string if comment hasn't been saved
        return '';
    }

    /**
     * Updates an existing Comment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $articleId
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($articleId, $id)
    {
        //check user
        if (!Yii::$app->user->isGuest) {
            //load model from DB
            $formModel = $this->findModel($id);
            //load form from post array to model and save to DB
            if ($formModel->load(Yii::$app->request->post()) && $formModel->save($articleId)) {
                return $this->redirect(['news/view', 'id' => $articleId]);
            }
        }

        return $this->redirect(['news/view', 'id' => $articleId]);
    }

    /**
     * Deletes an existing Comment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $articleId
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($articleId, $id)
    {
        //check user
        if (!Yii::$app->user->isGuest) {
            //delete from DB
            $this->findModel($id)->delete();
        }

        return $this->redirect(['news/view', 'id' => $articleId]);
    }

    /**
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
