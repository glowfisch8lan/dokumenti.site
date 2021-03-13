<?php

namespace app\modules\system\models\history;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\system\models\transactions\Transactions;
use app\modules\system\models\users\Users;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property int $user_id
 * @property int $amount
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property Transactions $transaction
 */
class History extends \yii\db\ActiveRecord
{
  const STATUS_BALANCE_FILLED = 1; //Пополнение баланса;
  const STATUS_BALANCE_FILL_AWAITS = 2; //Ожидание пополнения баланса;
  const STATUS_PAYMENT_CANCELLED = 3; //Платеж отменен;
  const STATUS_ORDER_PAID = 4; //Заказ оплачен;
  const STATUS_ORDER_PAY_AWAITS = 5; //Ожидание оплаты заказа;

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'system_history';
  }

  public function behaviors()
  {
    return [
      TimestampBehavior::className(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['user_id', 'amount', 'status'], 'required'],
      [['user_id', 'amount', 'status', 'created_at', 'updated_at'], 'integer'],
      [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
      [['transaction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Transactions::className(), 'targetAttribute' => ['transaction_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'user_id' => 'User ID',
      'amount' => 'Сумма',
      'description' => 'Описание',
      'status' => 'Status',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  /**
   * Gets query for [[User]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getUser()
  {
    return $this->hasOne(Users::className(), ['id' => 'user_id']);
  }

  /**
   * Gets query for [[Transactions]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getTransaction()
  {
    return $this->hasOne(Transactions::className(), ['id' => 'transaction_id']);
  }

}
