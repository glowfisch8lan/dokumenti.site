<?php

namespace app\modules\system\controllers;

use yii\web\Controller;

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
        return $this->render('order');
    }
}
