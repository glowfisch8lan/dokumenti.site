<?php

namespace app\modules\system\models\transactions;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "transactions".
 *
 * @property int $id
 * @property int|null $tb_payment_id
 * @property int|null $tb_card_id
 * @property string|null $tb_pan
 * @property string|null $tb_exp_date
 * @property string|null $tb_token
 * @property int|null $tb_amount
 * @property int $status
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Orders[] $orders
 */
class Transactions extends \yii\db\ActiveRecord
{

  const CREATED = 0;
  const AUTHORIZED = 1;
  const CONFIRMED = 2;
  const REVERSED = 3;
  const PARTIAL_REFUNDED = 4;
  const PARTIAL_REVERSED = 5;
  const REFUNDED = 6;
  const REJECTED = 7;


  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'system_transactions';
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
      [['tb_payment_id', 'tb_card_id', 'tb_amount', 'created_at', 'updated_at', 'status', 'user_id'], 'integer'],
      [['tb_token'], 'string'],
      [['tb_pan'], 'string', 'max' => 16],
      [['tb_exp_date'], 'string', 'max' => 4],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'tb_payment_id' => 'Tb Payment ID',
      'tb_card_id' => 'Tb Card ID',
      'tb_pan' => 'Tb Pan',
      'tb_exp_date' => 'Tb Exp Date',
      'tb_token' => 'Tb Token',
      'tb_amount' => 'Tb Amount',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  /**
   * Gets query for [[Orders]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getOrders()
  {
    return $this->hasMany(Orders::className(), ['transaction_id' => 'id']);
  }
}
