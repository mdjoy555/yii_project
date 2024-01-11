<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use GuzzleHttp\Psr7\Ruquest;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Posts;
use app\models\PostSearch;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
     *
     * @return string
     */

    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate()
    {
        $post = new Posts();
        $formData = Yii::$app->request->post();
        if($post->load($formData))
        {
            if($post->save())
            {
                Yii::$app->getSession()->setFlash('message','Post Created Successfully');

                return $this->redirect(['index']);
            }
            else
            {
                Yii::$app->getSession()->setFlash('message','Failed to Create');
            }
        }

        return $this->render('create',['post' => $post]);
    }

    public function actionView($id)
    {
        $post = Posts::findOne($id);

        return $this->render('view',['post' => $post]);
    }

    public function actionUpdate($id)
    {
        $post = Posts::findOne($id);
        $formData = Yii::$app->request->post();
        if($post->load($formData) && $post->save())
        {
            Yii::$app->getSession()->setFlash('message','Post Updated Successfully');

            return $this->redirect(['index','id' => $post->id]);
        }
        else
        {
            return $this->render('update',['post' => $post]);
        }
    }

    public function actionDelete($id)
    {
        $post = Posts::findOne($id)->delete();
        if($post)
        {
            Yii::$app->getSession()->setFlash('message','Post Deleted Successfully');

            return $this->redirect('index');
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionProvider()
    {
        $query = new Qeury;
        $data = $query->from('category')->all();
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pagesize' => 10,
                'page' => 1
            ]
        ]);

        $record = $provider->getModels();
        // echo "<pre>";
        // print_r($record);
        // die();
    }

    public function findModel($id)
    {
        if($model=Posts::findOne($id)!==null)
        {
            return $model;
        }

        throw new NotFoundHttpException("The requested page does not exist!");
    }
}
