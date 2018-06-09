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
                    'model' => $formModel->getModel(),
                ]
            );
        }

        // return empty string if comment hasn't been saved
        return '';
    }

    /**
     * Send to sever comment(model) and check that
     * If check is successful, the server will be return comment to commentForm.
     * @param integer $articleId
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdating($articleId, $id)
    {
        // if request isn't AJAX or user isn't authorized
        if(!Yii::$app->request->isAjax || Yii::$app->user->isGuest) {
            // return empty string to ajax-callback function
            return '';
        }

        //load model
        $formModel = $this->findModel($id);

        //check id comment, id article and id user
        if ($formModel->id == $id && $formModel->news_id == $articleId && $formModel->user_id == Yii::$app->user->id) {
            //return model JSON
            return json_encode($formModel);
        }

        // return empty string if comment hasn't been find
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
