<?php

namespace app\modules\system\controllers;

use Yii;
use yii\web\Controller;
use app\modules\system\models\users\UsersOrders;

/**
 * Default controller for the `system` module
 */
class DefaultController extends Controller
{
    /**
     * Мои сайты
     * @return string
     */
    public function actionSites()
    {
        return $this->render('sites');
    }

    /**
     * Заказы;
     * @return string
     */
    public function actionOrders()
    {
        return $this->render('orders');
    }

    /**
     * Сделать заказ;
     * @return string
     */
    public function actionOrder()
    {

        if(Yii::$app->request->isPost)
        {
            $model = new UsersOrders();
            $value = UsersOrders::get(1);

            if($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('alert-success', 'Ваш заказ №<b>'.$model->id.'</b> успешно принят!');
                return $this->redirect('/system/default/order');
            }
        }

        $model = new UsersOrders();
        return $this->render('order', ['model' => $model]);
    }
}
