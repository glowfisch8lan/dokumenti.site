<?php


namespace app\modules\system\helpers;
use app\modules\system\models\rbac\AccessControl;
use app\modules\system\Module;
use Yii;
use app\modules\system\models\users\UsersBalance;
use yii\bootstrap4\Alert;

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
                    <p>Баланс: <span>'.UsersBalance::getBalance(Yii::$app->user->identity->id).' ₽</span></p>
                </div>
            </div>
        </section>';

        $typeAlert = ['alert-success', 'alert-warning', 'alert-danger'];
        foreach ($typeAlert as $key => $value) {
            $sessionKey = Yii::$app->session->getFlash($value);
            if (!is_null($sessionKey)) {
                $body = $sessionKey;
                break;
            }
        }
        if (isset($body)) {
            $code .= '<section class="alert"><div class="alert">'. Alert::widget([
                'options' => [
                    'class' => ' alert-info',
                ],
                'body' => $body,
            ]).'</div></div></section>';
        }


        return $code;
    }

    /**
     * Генерация меню в Личном кабинете;
     *
     * @param null $action : позволяет выделить активный link
     * @return string
     */
    public static function menu($action = null){
        $array = Yii::$app->getModule('system')->routes;

        $code = null;
        foreach($array as $item => $value){
            if($value['visible'] && AccessControl::checkAccess(Yii::$app->user->identity->id,$value['access']))
                $code .= '<a href="'.$value['route'].'" class="'.(($value['id'] === $action) ? 'active' : null).'">'.$value['title'].'</a>';
        }

        return '<div class="main-cabinet-menu"><div class="main-cabinet-menu-container">'.$code.'</div></div>';
    }
}