<?php

namespace app\controllers;

use app\modules\system\models\history\History;
use app\modules\system\models\users\UsersOrders;
use app\modules\system\models\transactions\Transactions;
use app\modules\system\models\users\Users;
use app\services\PaymentService;
use yii\base\Controller;
use yii\helpers\Json;

class CallbackController extends Controller
{

  public function actionTb()
  {
    \Yii::$app->response->data = 'OK';

    if(!\Yii::$app->request->isPost) {
      \Yii::$app->response->data = 'Api error';
    }

    $response = Json::decode(\Yii::$app->request->rawBody);

    $db_transaction = \Yii::$app->db->beginTransaction();

    $transaction = Transactions::findOne($response['OrderId']);
    $transaction->status = $response['Status'] === 'CONFIRMED' ? 2 : 1;
    $transaction->tb_payment_id = $response['PaymentId'];
    $transaction->tb_amount = $response['Amount'];
    $transaction->tb_card_id = $response['CardId'];
    $transaction->tb_pan = $response['Pan'];
    $transaction->tb_exp_date = $response['ExpDate'];
    $transaction->tb_token = $response['Token'];

    $history = new History();
    $history->user_id = $transaction->user_id;
    $history->amount = $transaction->tb_amount;
    $history->transaction_id = $transaction->id;

    $order = UsersOrders::find()->where(['transaction_id' => $response['OrderId']])->one();

    if (!is_null($order)) {
      $history->description = "Пакет {$order->category->name} для {$order->url} оплачен";
      $history->status = History::STATUS_ORDER_PAID;
      $is_callback_duplicated = !is_null(History::find()->where([
        'transaction_id' => $transaction->id,
        'status' => History::STATUS_ORDER_PAID
      ])->one());
//      $messageParams = [
//        'type' => 'order',
//        'mailTo' => $order->user->email,
//        'order' => $order
//      ];
    } else {
      $history->description = "Пополнение баланса";
      $history->status = History::STATUS_BALANCE_FILLED;

      $user = Users::findOne($transaction->user_id);
      $user->balance += $response['Amount'];
      $user->save();

      $is_callback_duplicated = !is_null(History::find()->where([
        'transaction_id' => $transaction->id,
        'status' => History::STATUS_BALANCE_FILLED
      ])->one());

//      $messageParams = [
//        'type' => 'refill',
//        'user' => $user,
//        'amount' => $response['Amount']Amountl'
//      ];
    }

    if ($transaction->save() && $history->save() && !$is_callback_duplicated) {
      //(new PaymentService())->sendEmails($messageParams);
      $db_transaction->commit();
    } else {
      $db_transaction->rollBack();
    }
  }
}