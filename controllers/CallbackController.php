<?php

namespace app\controllers;

use app\modules\system\models\history\History;
use app\modules\system\models\users\UsersOrders;
use app\modules\system\models\transactions\Transactions;
use app\modules\system\models\users\Users;
use app\services\PaymentService;
use phpDocumentor\Reflection\DocBlock\Description;
use yii\base\Controller;
use yii\helpers\Json;
use app\modules\system\models\users\UsersBalance;

/**
 * Класс, слушающий webhook от Банка;
 *
 * Class CallbackController
 * @package app\controllers
 */
class CallbackController extends Controller
{

    /**
     * Получаем ответ о транзакции от Тинькофф-Банка;
     * @throws \yii\db\Exception
     */
    public function actionTb()
      {
        \Yii::$app->response->data = 'OK';

        if(!\Yii::$app->request->isPost){
          \Yii::$app->response->data = 'Api error';
        }


        $response = Json::decode(\Yii::$app->request->rawBody);

        $db_transaction = \Yii::$app->db->beginTransaction();

        /** Ищем транзакцию в БД, которую записали ранее */

        $transaction = Transactions::findOne($response['OrderId']);
        $transaction->status = ($response['Success']) ? Transactions::CONFIRMED : Transactions::REJECTED;
        $transaction->tb_payment_id = $response['PaymentId'];
        $transaction->tb_amount = (floatval($response['Amount'])/100);
        $transaction->tb_card_id = $response['CardId'];
        $transaction->tb_pan = $response['Pan'];
        $transaction->tb_exp_date = $response['ExpDate'];
        $transaction->tb_token = $response['Token'];

         /** Записываем транзакцию в историю; */
        $history = new History();
        $history->user_id = $transaction->user_id;
        $history->amount = $transaction->tb_amount;
        $history->transaction_id = $transaction->id;

        $order = UsersOrders::find()->where(['transaction_id' => $response['OrderId']])->one();

        /** Оплата заказа; */
        if (!is_null($order))
        {
          $history->description = "Пакет {$order->category->name} для {$order->url} оплачен";
          $history->status = History::STATUS_ORDER_PAID;
          $is_callback_duplicated = !is_null(History::find()->where([
            'transaction_id' => $transaction->id,
            'status' => History::STATUS_ORDER_PAID
          ])->one());
        }
        /** Пополнение баланса */
        else {
            /** Описание истории; */
            $history->description = "Пополнение баланса";

            /** Устанавливаем статус в истории в режим "Ожидания"; */
            $history->status = History::STATUS_BALANCE_FILL_AWAITS;

            /** Если пришел отказ в транзакции, то ставим в историю об этом; */
            $history->status = ($transaction->status != $transaction::REJECTED) ?  History::STATUS_BALANCE_FILLED : History::STATUS_PAYMENT_CANCELLED;

            /** Если транзакция подтверждена, то пополняем баланс, и записываем в историю иначе пропускаем; */
            if($transaction->status === Transactions::CONFIRMED)
            {
                $user_balance = UsersBalance::findOne(['user_id' => $transaction->user_id]);
                $user_balance->value += $transaction->tb_amount;
                $user_balance->save();
            }

            /** Проверяем дубликат, иначе пишет >1 раза в базу ; */
            $is_callback_duplicated = !is_null(History::find()->where([
                'transaction_id' => $transaction->id,
                'status' => History::STATUS_BALANCE_FILLED
              ])->one());
         }


        if ($transaction->save() && $history->save() && !$is_callback_duplicated) {
                $db_transaction->commit();
        } else {
          $db_transaction->rollBack();
        }
      }
}