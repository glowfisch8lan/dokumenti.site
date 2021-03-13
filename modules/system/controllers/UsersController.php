<?php

namespace app\modules\system\controllers;

use app\modules\system\helpers\ArrayHelper;
use app\modules\system\models\users\Groups;
use Yii;
use app\modules\system\models\users\Users;
use app\modules\system\models\users\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\system\models\rbac\AccessControl;

/**
 * UsersController отвечающий за заказы
 */
class UsersController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return;
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();

        /** Добавляем в группы */
        if ( $model->load(Yii::$app->request->post()) && $model->save()) {
                Groups::addMembers(ArrayHelper::indexMap($model->groups, $model->id)); //Добавляем список групп в system_users_groups заново;
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post()) && $model->save()){
            /** Удаляем все группы пользователя; */
            Groups::removeAllGroupMember($id);
            /** Добавляем список групп в system_users_groups заново; */
            Groups::addMembers(ArrayHelper::indexMap($model->groups, $model->id));

            return $this->redirect(['index']);
        }



        $model->password = null;

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Возможность входа администратору под другим пользователем;
     *
     * @param $id
     * @return void|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionLogin($id)
    {
        if(AccessControl::checkAccess(
            Yii::$app->user->identity->id,
            ArrayHelper::getDataById(Yii::$app->getModule('system')->routes, 'login-by-user')['access']
        ))
        {
            $user = $this->findModel($id);
            Yii::$app->user->login($user);
            return $this->redirect('/system/orders');
        }
        return;
    }

    public function actionProfile($id)
    {

    }
}
