<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\components\forms\LoginForm;
use frontend\components\forms\PasswordResetRequestForm;
use frontend\components\forms\ResetPasswordForm;
use frontend\components\forms\SignupForm;
use frontend\components\forms\ContactForm;
use frontend\models\NewsFinder;
use common\models\Category;
use common\models\Tags;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     * @param integer $categoryId NULL - all news; integer - news for selected category;
     * @param string $selectedTags NULL - all news
     * @return mixed
     * @throws NotFoundHttpException
     */
    //  .../news/category/1/tag/1
    //  .../news/category/1
    //  .../news/category/1/tag/1+2
    // .../news/tag/1+2
    public function actionIndex($categoryId = null, $selectedTags = null)
    {
        $selectedCategory = null;
        $selectedTagsArray = $selectedTagsIdArray = array();

        //check tag if it's set
        if ($selectedTags) {
            $selectedTagsIdArray = explode('+', $selectedTags);
            //break string by Id's
            if (!empty($selectedTagsIdArray)) {
                //create array of tags by id
                $selectedTagsArray = Tags::find()
                    ->andWhere(['display' => Tags::DISPLAY_ON])
                    ->andWhere(['in', 'id', $selectedTagsIdArray])
                    ->all();
            }
        }

        //check category if it's set
        if ($categoryId) {
            //selected category
            $selectedCategory = Category::find()
                ->andWhere(['id' => $categoryId, 'display' => Category::DISPLAY_ON])
                ->one();
            //if category is not found
            if (!$selectedCategory) {
                throw new NotFoundHttpException();
            }
        }

        $newsFinder = new NewsFinder();

        $newsFinder->category = $selectedCategory;
        $newsFinder->tags     = $selectedTagsIdArray;

        $dataProvider = $newsFinder->getDataProvider();

        //array of categories
        $categories = Category::find()->andWhere(['display' => Category::DISPLAY_ON])->all();
        //array of tags
        $tags = Tags::find()->andWhere(['display' => Tags::DISPLAY_ON])->all();


        return $this->render('index', [
            'dataProvider'         => $dataProvider,
            'categories'           => $categories,
            'tags'                 => $tags,
            'selectedCategory'     => $selectedCategory,
            'selectedTagsArray'    => $selectedTagsArray,
            'selectedTagsIdArray'  => $selectedTagsIdArray,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {

                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }

        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
