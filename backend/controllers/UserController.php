<?php

namespace backend\controllers;

use common\models\Markers;
use common\models\User;
use Yii;
use backend\models\user\UserForm;
use backend\models\user\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete', 'view', 'index', 'avatardelete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //init form model instance
        $formModel = new UserForm(['scenario' => UserForm::SCENARIO_CREATE]);

        //set AR model to form
        $formModel->setModel(new User());


        if ($formModel->load(Yii::$app->request->post()) && $formModel->save()) {
            return $this->redirect(['view', 'id' => $formModel->model->id]);
        } else {
            return $this->render('create', [
                'formModel' => $formModel,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        //init form model instance
        $formModel = new UserForm(['scenario' => UserForm::SCENARIO_UPDATE]);

        $formModel->setModel($this->findModel($id), true);


        if ($formModel->load(Yii::$app->request->post()) && $formModel->save()) {
            return $this->redirect(['view', 'id' => $formModel->model->id]);
        } else {
            return $this->render('update', [
                'formModel' => $formModel,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param integer $id
     * @return mixed
     *
     * TODO: should do the same operation without redirect (because another form fields will be changed).
     * TODO: should do it in AJAX request and in response callback to remove image from html.
     */
    public function actionAvatardelete($id)
    {
        //init form model instance
        $formModel = new UserForm(['scenario' => UserForm::SCENARIO_UPDATE]);

        $formModel->setModel($this->findModel($id), true);
        //get absolute path avatar
        $imageFile = $formModel->model->getImageFileAbsolutePath();
        //check exist avatar
        if (file_exists($imageFile)) {
            //delete file from server
            unlink($imageFile);
        }
        //remove filename from model
        //TODO: should use insert/update operations ONLY VIA form object. E.g. `$model->imagefile = null;` AND then update model IN FORM.
        $formModel->model->imagefile = '';

        //save model
        //TODO: in this case all another fields will be submitted BUT user doesn't want do it
        if ($formModel->load(Yii::$app->request->post()) && $formModel->save()) {
            //redirect to update
            return $this->redirect(['update', 'id' => $formModel->model->id]);
        }else{
            return $this->redirect(['index']);
        }
    }
}
