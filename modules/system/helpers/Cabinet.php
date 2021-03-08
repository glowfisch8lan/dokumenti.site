<?php


namespace app\modules\system\helpers;
use app\modules\system\models\rbac\AccessControl;
use app\modules\system\Module;
use Yii;
use app\modules\system\models\users\UsersBalance;
use yii\bootstrap4\Alert;

class Cabinet
{

    /**
     * Меню-строка пользовательского баланса на каждом Views;
     *
     * @return string
     * @throws \Exception
     */
    public static function topMenu(){

        /**
         * HTML-шаблон
         */
        $code = '<section class="cabinet-top-menu">
            <div class="cabinet-top-menu-container">
                <div class="cabinet-top-menu-left">
                    <p>'.Yii::$app->user->identity->username.'</p>
                </div>
                <div class="cabinet-top-menu-right">
                    <a href="#" type="button" data-toggle="modal" data-target="#myModal">Пополнить</a>
                    <p>Баланс: <span>'.UsersBalance::getBalance(Yii::$app->user->identity->id).' ₽</span></p>
                </div>
            </div>
            <!-- Модальное окно -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                  </div>
                  <div class="modal-body">
                    ...
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div>
                </div>
              </div>
            </div>
        </section>';

        $typeAlert = ['alert-success', 'alert-warning', 'alert-danger'];

        foreach ($typeAlert as $key => $value) {
            $sessionKey = Yii::$app->session->getFlash($value);

            if (!is_null($sessionKey)){
                $class = $value;
                $body = $sessionKey;
                break;
            }
        }

        if (isset($body))
            $code .= '<div class="box-alert"><div>' . Alert::widget( ['options' => ['class' => $class], 'body' => $body] ) . '</div></div>';

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