<?php


namespace app\services;


use app\modules\system\models\users\UsersOrders;
use Yii;

class PaymentService
{
  public function payOrder($transactionId)
  {
    $api = new TinkoffMerchantAPI(Yii::$app->params['tb_terminalKey'], Yii::$app->params['tb_secretKey']);

    $order = UsersOrders::find()->where(['transaction_id' => $transactionId])->one();

    return $api->init([
      'TerminalKey' => Yii::$app->params['tb_terminalKey'],
      'Amount' => $order->category->price * 100,
      'Description' => 'Оплата заказа №' . $order->id,
      'OrderId' => $transactionId,
      'IP' => Yii::$app->request->getUserIP(),
      'PayType' => 'O',
      'SuccessURL' => \yii\helpers\Url::base('https') . '/cabinet/my-orders'
    ]);
  }

  public function payRefill($orderId, $amount)
  {

    $api = new TinkoffMerchantAPI(Yii::$app->params['tb_terminalKey'], Yii::$app->params['tb_secretKey']);

    return $api->init([
      'TerminalKey' => Yii::$app->params['tb_terminalKey'],
      'Amount' => $amount * 100,
      'OrderId' => $orderId,
      'IP' => Yii::$app->request->getUserIP(),
      'PayType' => 'O',
      'Description' => 'Пополнение баланса личного кабинета',
      'SuccessURL' => \yii\helpers\Url::base('https') . '/',
      'NotificationURL' => \yii\helpers\Url::base('https') . '/callback/tb'
    ]);
  }

  public function sendEmails($params)
  {
    if ($params['type'] === 'order') {
      return $this->userEmail($params) && $this->adminEmail($params);
    } else {
      return $this->userEmail($params);
    }

  }

  private function userEmail($params)
  {
    if ($params['type'] === 'order') {
      Yii::$app->mailer->compose('user-order-paid', ['order' => $params['order']])
        ->setTo($params['mailTo'])
        ->setFrom(Yii::$app->params['senderEmail'])
        ->setSubject('Заказ №' . $params['order']->id . ' успешно оплачен')
        ->send();
    } else {
      Yii::$app->mailer->compose('user-balance-refilled', [
        'user' => $params['user'],
        'amount' => $params['amount']
      ])
        ->setTo($params['user']->email)
        ->setFrom(Yii::$app->params['senderEmail'])
        ->setSubject('Баланс личного кабинета пополнен')
        ->send();
    }

    return true;
  }

  private function adminEmail($params)
  {
    Yii::$app->mailer->compose('admin-order-paid', ['order' => $params['order']])
      ->setTo($params['adminEmail'])
      ->setFrom(Yii::$app->params['senderEmail'])
      ->setSubject('Заказ №' . $params['order']->id . 'оплачен')
      ->send();

    return true;
  }


}