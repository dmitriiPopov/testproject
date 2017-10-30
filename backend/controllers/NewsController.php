<?php

namespace backend\controllers;

use vova07\imperavi\actions\GetAction;
use Yii;
use common\models\News;
use backend\models\news\NewsSearch;
use backend\models\news\NewsForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{

    // DefaultController.php
    public function actions()
    {
        //var_dump(Yii::$app->params['staticBaseUrl']);
        return [
            'fileupload' => [
                'class'           => 'vova07\imperavi\actions\UploadAction',
                'url'             => Yii::$app->params['staticBaseUrl'] . '/news/content', // Directory URL address, where files are stored.
                'path'            => Yii::$app->params['absoluteStaticBasePath'] . '/news/content', // Or absolute path to directory where files are stored.
                'uploadOnlyImage' => false, // For not image-only uploading.
            ],
            'fileget' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url'     => Yii::$app->params['staticBaseUrl'] . '/news/content', // Directory URL address, where files are stored.
                'path'  => Yii::$app->params['absoluteStaticBasePath'] . '/news/content', // Or absolute path to directory where files are s
                'type' => GetAction::TYPE_FILES,
            ]
        ];
    }

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
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
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
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $formModel = new NewsForm(['scenario' => NewsForm::SCENARIO_CREATE]);

        $formModel->setModel(new News());

        if ($formModel->load(Yii::$app->request->post()) && $formModel->save()) {
            return $this->redirect(['view', 'id' => $formModel->model->id]);
        } else {
            return $this->render('create', [
                'formModel' => $formModel,
            ]);
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $formModel = new NewsForm(['scenario' => NewsForm::SCENARIO_UPDATE]);

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
     * Deletes an existing News model.
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
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
