<?php

namespace app\modules\system\controllers;

use app\modules\system\models\notifications\NotifyMail;
use app\modules\system\models\history\History;
use app\modules\system\models\users\UsersBalance;
use app\modules\system\models\users\UsersOrders;
use Yii;
use app\modules\system\models\settings\Settings;
use app\modules\system\models\settings\SettingsSearch;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;

/**
 * SettingsController implements the CRUD actions for Settings model.
 */
class PaymentController extends Controller
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
                ],
            ],
        ];
    }


    public function actionPay($order_id)
    {

        $order = $this->findOrder($order_id);

        $user_id = Yii::$app->user->identity->id;

        $balance = $this->findUserBalance($user_id);

        $order_coast = $order->getCoastOrder();

        /** Проверяем хватит ли денег на оплату на балансе */

        if( ($balance->value - $order_coast) < 0 ){
            Yii::$app->session->setFlash('alert-danger', 'Извините! Стоимость заказа '.$order_coast.' руб. На вашем балансе не достаточно средств.');
            return $this->redirect('/system/orders/index');
        }

        /** Списываем деньги с баланса пользователя */
        $balance->subtract($order_coast);
        if(!$balance->save())
            throw new ServerErrorHttpException('Извините! Произошла ошибка при списании денежных средств.');


        /** Обновление статуса платежа */
        $order->status = UsersOrders::STATUS_ORDER_PAID;
        $order->stage = UsersOrders::IN_WORK;
        if(!$order->save())
            throw new ServerErrorHttpException('Извините! Произошла ошибка обновления статуса оплаты заказа.');

        /** Записываем в историю; */
        $history = new History();
        $history->user_id = $user_id;
        $history->amount = $order_coast;
        $history->transaction_id = null;
        $history->description = 'Оплата заказа #' . $order_id;
        $history->status = History::STATUS_ORDER_PAID;

        if(!$history->save())
            throw new ServerErrorHttpException('Извините! Произошла ошибка записи в Историю платежей.');


        Yii::$app->session->setFlash('alert-success', 'Ваш заказ №<b>'.$order_id.'</b> успешно оплачен!');

        (new NotifyMail())->set(['to' => Yii::$app->params['emailForNotifications'], 'message' => 'Пользователь '.Yii::$app->user->identity->username. ' успешно оплатил заказ #' . $order_id, 'subject' => 'Оплата заказ #'.$order_id.'', 'type' => 'payment'])->send();

        return $this->redirect('/system/orders');
    }


    protected function findOrder($id)
    {
        if (($model = UsersOrders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findUserBalance($user_id)
    {
        if (($model = UsersBalance::findOne(['user_id' => $user_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Баланс пользователя не найден.');
    }
}
