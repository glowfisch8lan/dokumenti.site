<?php


namespace app\modules\system\helpers;
use Yii;
class Cabinet
{

    public static function topMenu(){
        $code = '<section class="cabinet-top-menu">
            <div class="cabinet-top-menu-container">
                <div class="cabinet-top-menu-left">
                    <p>'.Yii::$app->user->identity->username.'</p>
                </div>
                <div class="cabinet-top-menu-right">
                    <a href="#">Пополнить</a>
                    <p>Баланс: <span>0 ₽</span></p>
                </div>
            </div>
        </section>';
        return $code;
    }

    public static function menu(){
        $array = [
            [
                'id' => 'order',
                'linkPath' => '/'.Yii::$app->controller->module->id . '/' . Yii::$app->controller->id .'/',
                'title' => 'Заказ документов'
            ],
            [
                'id' => 'sites',
                'linkPath' => '/'.Yii::$app->controller->module->id . '/' . Yii::$app->controller->id .'/',
                'title' => 'Мои сайты'
            ],
            [
                'id' => 'orders',
                'linkPath' => '/'.Yii::$app->controller->module->id . '/' . Yii::$app->controller->id .'/',
                'title' => 'Список заказов'
            ],
        ];

        $code = null;
        foreach($array as $item => $value){
            $code .= '<a href="'.$value['linkPath'].$value['id'].'" class="'.(($value['id'] === Yii::$app->controller->action->id) ? 'active' : null).'">'.$value['title'].'</a>';
        }

        return '<div class="main-cabinet-menu"><div class="main-cabinet-menu-container">'.$code.'</div></div>';
    }
}