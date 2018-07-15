<?php

namespace frontend\controllers;

use common\models\News;
use Yii;
use common\models\Comment;
use frontend\components\forms\CommentForm;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentsController implements the CRUD actions for Comment model.
 */
class CommentsController extends Controller
{
    /**
     * @var int
     */
    const MAX_NUMBER_OF_SECONDS_FOR_DELETING_COMMENT = 600;

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
     * @return string HTML-string
     */
    public function actionCreate($articleId)
    {
        // if request isn't AJAX or user isn't authorized
        if(!Yii::$app->request->isAjax || Yii::$app->user->isGuest) {

            throw new ForbiddenHttpException();
        }

        //TODO: НУЖНО ДИМЕ ПЕРЕПРОВЕРИТЬ!!!
        /*
         1) захожу на страницу новости
        2) заполняю name и content и добавляю комментарий
        3) комментарий добавляется и поле content очищается
        4) еще раз ввожу данные в поле content, нажимаю "Оставить комментарий", но при этом появляется валидационная ошибка - https://prnt.sc/jypat5 (ЭТО НЕВЕРНО)
         */

        /**@var $article News*/
        $article = News::findOne($articleId);
        if (!$article)
        {
            throw new NotFoundHttpException();
        }

        //init form model instance
        $formModel = new CommentForm(['scenario' => CommentForm::SCENARIO_CREATE]);
        $formModel->name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
        // create new instance of Comment model for saving below
        $formModel->setModel(new Comment());
        //set user
        $formModel->userId = Yii::$app->user->id;

        //set article to form model
        $formModel->setArticleModel($article);

        // save comment with data from request
        if ($formModel->load(Yii::$app->request->post()) && $formModel->save()) {

            //set 'name' to session
            $_SESSION['name'] = $formModel->name;

            // return html-code of one comment to ajax-callback
            return $this->renderPartial(
                '/news/_partial/commentItem',
                [
                    // set new comment ot view template
                    'model' => $formModel->getModel(),
                ]
            );
        }

        // return if comment hasn't been saved
        return $this->renderPartial('/news/_partial/commentFormItem', [
            'commentForm' => $formModel,
        ]);
    }

    /**
     * Send to sever comment(model) and check that
     * If check is successful, the server will be return comment to commentForm.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionOne($id)
    {
        //https://stackoverflow.com/questions/28831860/ajax-controller-action-in-yii2
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // if request isn't AJAX or user isn't authorized
        if(!Yii::$app->request->isAjax || Yii::$app->user->isGuest) {

            throw new ForbiddenHttpException();
        }

        //load model
        $model = $this->findModel($id);
        //set apply time for update
        $checkTime = time() - strtotime($model->updated_at ? $model->updated_at : $model->created_at);

        // if comment belongs to current user
        if ($checkTime < self::MAX_NUMBER_OF_SECONDS_FOR_DELETING_COMMENT && $model->user_id == Yii::$app->user->id) {
            //return comment data
            return $model->getAttributes();
        }

        // return empty string if comment hasn't been find
        return [];
    }

    /**
     * Updates an existing Comment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        // if request isn't AJAX or user isn't authorized
        if(!Yii::$app->request->isAjax || Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException();
        }

        /**@var $commentModel Comment*/
        $commentModel = $this->findModel($id);
        if (!$commentModel)
        {
            throw new NotFoundHttpException();
        }

        $formModel = new CommentForm(['scenario' => CommentForm::SCENARIO_UPDATE]);

        $formModel->setModel($commentModel, true);

        // if comment belongs to current user
        if ($formModel->userId != Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        //load form from post array to model and save to DB
        if ($formModel->load(Yii::$app->request->post()) && $formModel->save()) {

            //set 'name' to session
            $_SESSION['name'] = $formModel->name;

            // return html-code of one comment to ajax-callback
            return $this->renderPartial(
                '/news/_partial/commentItem',
                [
                    // set update comment ot view template
                    'model' => $formModel->model,
                ]
            );
        }

        // return if comment hasn't been saved
        return $this->renderPartial('/news/_partial/commentFormItem', [
            'commentForm' => $formModel,
        ]);
    }

    /**
     * Deletes an existing Comment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //check status for action status and check deleted for comment deleted status
        $result = ['status' => false, 'deleted' => false];

        // if request isn't AJAX or user isn't authorized
        if(!Yii::$app->request->isAjax || Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException();
        }

        $model     = $this->findModel($id);
        //set apply time for delete
        $checkTime = time() - strtotime($model->updated_at ? $model->updated_at : $model->created_at);

        //check delete from DB
        if ($checkTime < self::MAX_NUMBER_OF_SECONDS_FOR_DELETING_COMMENT && $model->delete()) {
            //set deleted status on TRUE
            $result['deleted'] = true;
        }
        //set action status on TRUE
        $result['status'] = true;
        //return result
        return $result;
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
