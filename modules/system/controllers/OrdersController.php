<?php

namespace app\modules\system\controllers;

use Yii;
use app\modules\system\models\users\UsersOrders;
use app\modules\system\models\users\UsersOrdersSearch;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\system\models\rbac\AccessControl;
use app\modules\system\helpers\ArrayHelper;

/**
 * OrdersController implements the CRUD actions for UsersOrders model.
 */
class OrdersController extends Controller
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
     * Фильтрация заказов, чтобы пользователь не мог получить доступ к чужим заказам;
     */
    public function beforeAction($action)
    {
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    /**
     * Lists all UsersOrders models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $searchModel = new UsersOrdersSearch();


        /**
         * Разрешение: Показать все заказы;
         */
        if(AccessControl::checkAccess(
            Yii::$app->user->identity->id,
            ArrayHelper::getDataById(Yii::$app->getModule('system')->routes, 'all-user-orders')['access']
        ))
            $query = UsersOrders::find();

        $query = (isset($query)) ? $query : UsersOrders::find()->where(['user_id' => Yii::$app->user->identity->id]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $query);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single UsersOrders model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

//    /**
//     * Creates a new UsersOrders model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return mixed
//     */
//    public function actionCreate()
//    {
//        $model = new UsersOrders();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Категория "Сделать заказ"
     * @return string
     */
    public function actionCreate()
    {

        if(Yii::$app->request->isPost)
        {
            $model = new UsersOrders();
            $model->user_id = Yii::$app->user->identity->id;
            if($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('alert-success', 'Ваш заказ №<b>'.$model->id.'</b> успешно принят!');
                return $this->redirect('/system/orders/create');
            }
        }

        $model = new UsersOrders();
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing UsersOrders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UsersOrders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        var_dump($model->user_id);
        if($model->user_id === Yii::$app->user->identity->id){
            $model->delete();
            Yii::$app->session->setFlash('alert-danger', 'Ваш заказ №<b>'.$model->id.'</b> успешно удален!');
            return $this->redirect(['index']);
        }
        throw new Exception('Заказ не принадлежит вам! Удаление невозможно');

    }

    /**
     * Блокировка/разблокировка заказа, привязка/отвязка от Адвоката;
     *
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionLocking($id)
    {
        $model = $this->findModel($id);

        if($model->locking != Yii::$app->user->identity->id)
        {
            $model->locking = Yii::$app->user->identity->id;
            $model->save();
            Yii::$app->session->setFlash('alert-success', 'Заказ №<b>'.$model->id.'</b> взят к исполнению!');
            return $this->redirect(['index']);
        }
        else{
            $model->locking = null;
            $model->save();
            Yii::$app->session->setFlash('alert-warning', 'Вы отказались от исполнения Заказа №<b>'.$model->id.'</b>!');
            return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }



    /**
     * Finds the UsersOrders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UsersOrders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsersOrders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
