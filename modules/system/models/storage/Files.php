<?php

namespace app\modules\system\models\storage;


use app\modules\system\models\users\UsersOrders;
use yii\base\Model;

class Files extends Model
{

    public function getCompleteOrderFiles()
    {
        $user_id = \Yii::$app->user->identity->id;
        $orders = UsersOrders::findAll(['user_id' => $user_id]);
        foreach ($orders as $key => $value)
        {
            var_dump($value->getOrderFiles());
        }
    }

    public function getPotentialOrderFiles()
    {
        $user_id = \Yii::$app->user->identity->id;
        $orders = UsersOrders::findAll(['user_id' => $user_id]);
        return $orders;
    }
}