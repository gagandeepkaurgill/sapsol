<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
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
        return $this->render('index', []);
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
			$user = User::findByUsername($model->username);
			$id = $user->id;
			if($user->email_verification == 'Yes') {
				return $this->goBack();
			} else {
				Yii::$app->user->logout();				
				Yii::$app->session->setFlash('error', "Your account is not verified yet.");
				if (User::verificationEmail($id)) {
					Yii::$app->session->setFlash('warning', "We have sent you verification email again. Please verify your account. Thanks!");	
				} else {
					Yii::$app->session->setFlash('error', "Something wrong with your account. Please try again later.");
				}				
				
			}            
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
	
	public function actionAddadmin() {
		$model = User::find()->where(['username' => 'admin2'])->one();
		if (empty($model)) { 
			$user = new User();
			$user->username = 'admin';
			$user->name = 'admin admin';
			$user->Address = 'admin address admin';
			$user->email = 'admin@.com';
			$user->setPassword('admin'); 
			$user->created_at = date('Y-m-d H:i:s');
			$user->updated_at = date('Y-m-d H:i:s');
			$user->generateAuthKey(); 
			if ($user->validate() && $user->save()) {
				die('good');
			} else {
				print_r($user->getErrors()); die('err'); 
			}
		}
	}
	
	public function actionTest()
    {
        echo 'testing';			
		/*\Yii::$app->mailer->compose()
			->setFrom('gagangill351@gmail.com')
			->setTo('jaspreetkaurmaan@gmail.com')
			->setSubject('Yii2 Testing')
			->setHtmlBody('<b>Your content goes here.....</b>')
			->send();*/
    }
}
