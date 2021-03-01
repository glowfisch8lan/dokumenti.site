<?php

namespace app\modules\system\models\users;

use Yii;

/**
 * This is the model class for table "users_balance".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $value
 *
 * @property SystemUsers $user
 */
class UsersBalance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_balance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'value'], 'integer'],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SystemUsers::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(SystemUsers::className(), ['id' => 'user_id']);
    }

    /**
     * Получить текущий баланс пользователя из Кеша Базы users_balance;
     *
     * @param $id
     * @return UsersBalance|null
     */
    public static function getBalance($id)
    {
        $user = self::findOne(['user_id' => $id]);
        if(!isset($user->value))
            return 0;

        return $user->value;
    }
}
