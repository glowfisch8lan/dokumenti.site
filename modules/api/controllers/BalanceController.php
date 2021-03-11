<?php


namespace app\modules\api\controllers;


use app\modules\system\models\history\History;
use app\modules\system\models\users\Users;
use app\modules\system\models\transactions\Transactions;
use app\modules\system\models\users\UsersOrders;
use app\services\PaymentService;
use Yii;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\Response;

/**
 * Работа с балансом пользователя
 *
 * Class BalanceController
 * @package app\modules\api\controllers
 */
class BalanceController extends Controller
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

    /**
     *  Все ответы в формате JSON;
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
  public function beforeAction($action)
  {
    Yii::$app->response->format = Response::FORMAT_JSON;

    return parent::beforeAction($action);
  }

   /**
    * Пополнение баланса
    */
  public function actionIncrease()
  {

    $amount = Yii::$app->request->post('amount'); //Сумма платежа;
    $payment_type_id = (int)Yii::$app->request->post('payment_type'); //Тип платежа

    $history = new History();
    $history->description = 'Инициализация транзакции';

    if ($payment_type_id !== UsersOrders::PAYMENT_TYPE_INVOICE) {
      $transaction = new Transactions();

      $transaction->status = Transactions::CREATED;
      $transaction->user_id = Yii::$app->user->identity->id;

      $transaction->save();

      $history->transaction_id = $transaction->id;

    }

    $history->user_id = Yii::$app->user->identity->id;
    $history->amount = $amount;

    $history->status = History::STATUS_BALANCE_FILL_AWAITS;

    if ($history->save()) {
      if ($payment_type_id !== UsersOrders::PAYMENT_TYPE_INVOICE) {
        $service = new PaymentService();
        Yii::$app->response->data = Json::decode($service->payRefill($transaction->id, $amount));
      } else {
        $this->sendEmail(Yii::$app->user->identity, $amount);
        Yii::$app->response->data = ['result' => 'invoice-request'];
      }

    }
  }

    /**
     * Отправка email пользователю
     *
     * @param Users $user
     * @param $amount
     */
  private function sendEmail(Users $user, $amount)
  {
    Yii::$app->mailer->compose('invoice-request-refill', ['user' => $user, 'amount' => $amount])
      ->setTo(Yii::$app->params['adminEmail'])
      ->setFrom(Yii::$app->params['senderEmail'])
      ->setSubject('Получен запрос на выставление счёта')
      ->send();
  }
}