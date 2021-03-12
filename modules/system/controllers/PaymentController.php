<?php

namespace app\modules\system\controllers;

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
        $user_balance = UsersBalance::getBalance($user_id);
        $order_coast = $order->getCoastOrder();
        if( $user_balance-$order_coast < 0 )
            throw new ServerErrorHttpException('Извините! На вашем балансе не достаточно средств.');


        //var_dump($order->status);
    }


    /**
     * Finds the Settings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Settings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findOrder($id)
    {
        if (($model = UsersOrders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
