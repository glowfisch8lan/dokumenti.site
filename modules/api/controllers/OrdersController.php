<?php


namespace app\modules\api\controllers;


use app\models\History;
use app\models\Orders;
use app\models\Transactions;
use app\services\PaymentService;
use Yii;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\Response;

class OrdersController extends Controller
{

  public function behaviors()
  {
    return [
      'corsFilter' => [
        'class' => 'yii\filters\Cors',
        'cors' => [
          'Origin' => ['*'],
          'Access-Control-Request-Method' => ['POST'],
          'Access-Control-Request-Headers' => ['*'],
        ],
      ],
      'verbs' => [
        'class' => \yii\filters\VerbFilter::className(),
        'actions' => [
          '*' => ['POST'],
        ],
      ],
    ];
  }

  public function beforeAction($action)
  {
    Yii::$app->response->format = Response::FORMAT_JSON;

    return parent::beforeAction($action);
  }

  public function actionCreate()
  {
    $order = new Orders();
    $payment_type_id = (int)Yii::$app->request->post('payment_type');

    if ($payment_type_id !== Orders::PAYMENT_TYPE_INVOICE) {
      $transaction = new Transactions();
      $transaction->status = Transactions::CREATED;
      $transaction->user_id = Yii::$app->user->identity->id;
      $transaction->save();
      $order->transaction_id = $transaction->id;
    }

    $order->url = Yii::$app->request->post('url');
    $order->category_id = Yii::$app->request->post('category_id');
    $order->payment_type = $payment_type_id;
    $order->user_id = Yii::$app->user->identity->id;

    $history = new History();
    $history->user_id = Yii::$app->user->identity->id;
    $history->amount = $order->category->price * 100;
    $history->transaction_id = $payment_type_id !== Orders::PAYMENT_TYPE_INVOICE ? $transaction->id : null;
    $history->status = History::STATUS_ORDER_PAY_AWAITS;

    if ($order->save() && $history->save()) {
      if ($payment_type_id === Orders::PAYMENT_TYPE_INVOICE) {
        $this->sendEmail($order);
      }
      Yii::$app->response->data = [
        'status' => 'ok',
        'transaction_id' => $order->transaction_id,
        'payment_type' => $order->payment_type,
      ];
    } else {
      Yii::$app->response->data = [
        'status' => 'error',
        'errors' => $order->errors
      ];
    }
  }

//  public function actionPay()
//  {
//    $transaction_id = Yii::$app->request->post('transaction_id');
//    $service = new PaymentService();
//    Yii::$app->response->data = Json::decode($service->payOrder($transaction_id));
//  }
//
//  private function sendEmail(UsersOrders $model)
//  {
//    Yii::$app->mailer->compose('invoice-request-order', ['order' => $model])
//      ->setTo(Yii::$app->params['adminEmail'])
//      ->setFrom(Yii::$app->params['senderEmail'])
//      ->setSubject('Получен запрос на выставление счёта')
//      ->send();
//  }

}